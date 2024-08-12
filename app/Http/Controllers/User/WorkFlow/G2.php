<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WorkFlow;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Stichoza\GoogleTranslate\GoogleTranslate;


class G2 extends Controller
{
     //
     private $url = 'http://127.0.0.1:8188/prompt';
     private $interrupt = 'http://127.0.0.1:8188/interrupt';
     private $inputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\input';
     private $inputError = 'D:\ProjectPHP\GradioApp\img';
     private $outputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\output';
 
     public function InputDataG2()
     {
         Session::forget("prompt");
         Session::forget("seed");
         Session::forget("url");
 
         $cookie = Cookie::get("token_account");
         $times = User::where("email",$cookie)->first();
         $ShowTimes = $times->times;
         $G = WorkFlow::find(2);
         return view("User.InputData_WorkFlow.G2",compact("ShowTimes","G"));
     }
 
     public function ShowImageG2(Request $request)
     {
        ini_set("max_execution_time",3600);

        $request->validate(["input" => 'image|mimes:jpg,jpeg,png|max:4048',]);

        $email = Cookie::get("token_account");
        $pattern = "/[^a-zA-Z0-9]/";
        $replacement = "_";
        $email = preg_replace($pattern, $replacement, $email);
         
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");
        $model = $request->input("model");
        $image = $request->file("input");

        Session::put("model",$model);

        if(!$request->hasFile("input"))
        {
            return redirect()->route("showworkflow");
        }

        $translator = new GoogleTranslate();
        $translated = $translator->setSource('vi')->setTarget('en')->translate($prompt);
 
        $process = json_decode(file_get_contents(storage_path('app/G2.json')), true);
 
        if ($model == "Ảnh thực tế")
        {
            $model = "majicmixRealistic_v7.safetensors";
        } 
        else if ($model == "Ảnh hình 3D") 
        {
            $model = "xxmixunreal_v10.safetensors";
        } 
        else if ($model == "Ảnh hoạt hình") 
        {
           
            $model = "chosenMix_chosenMix.ckpt";
        }
        
        $currentDate = Carbon::now();
        $main = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G2" .  $currentDate->format('Y-m-d') . ".png";
 
        $process["2"]["inputs"]["ckpt_name"] = $model;
        $process["3"]["inputs"]["text"] = $translated;
        $process["7"]["inputs"]["noise_seed"] = $seed;
        $process["15"]["inputs"]["image"] = $email . "/" . $main;

        $destinationPath = $this->inputDir . '/' . $email;
       
        if (!file_exists($destinationPath)) 
        {
             mkdir($destinationPath, 0777, true);
        }

        $image->move($destinationPath , $main);
 
        $previousImage = $this->getLatestImage($this->outputDir);
        $this->startQueue($process);
 
        try 
        {
            $latestImage = $this->waitForImage($previousImage);
            $publicPath = $this->moveToPublicDirectory($latestImage);
            $imageUrl = asset($publicPath);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return redirect()->route("showg2");
        } 
        catch (Exception $e) 
        {
            $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
            $publicPath = $this->moveToPublicDirectoryError($error_image_path);
            $imageUrl = asset($publicPath);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return redirect()->route("showg2");
        }
     }
 
     public function ImageG2()
     {
         $prompt = Session::get("prompt");
         $model = Session::get("model");
         $seed = Session::get("seed");
         $url = Session::get("url");
         $G = WorkFlow::find(2);
 
         if(empty($prompt) || empty($seed))
         {
             return redirect()->route("showworkflow");
         }
         else
         {
             return view("User.InputData_WorkFlow.ShowG",compact("prompt","seed","url","G","model"));
         }
     }
     private function getLatestImage($folder)
     {
         $files = array_filter(glob($folder . '/*'), 'is_file');
         usort($files, function($a, $b) {
             return filemtime($b) - filemtime($a);
         });
         return $files ? $files[0] : null;
     }
     /*public function stopQueue()
     {
         $client = new Client();
         $response = $client->post($this->interrupt);
 
         return redirect()->route("showworkflow");
     }*/
 
     private function startQueue($prompt)
     {
         $client = new Client();
         $response = $client->post($this->url, [
             'json' => ['prompt' => $prompt]
         ]);
     }
 
     private function waitForImage($previousImage)
     {
         while (true) {
             $latestImage = $this->getLatestImage($this->outputDir);
             if ($latestImage != $previousImage) {
                 return $latestImage;
             }
             sleep(3);
         }
     }
     private function moveToPublicDirectory($filePath)
     {
         $fileName = basename($filePath);
         $uniquePrefix = time(); 
         $uniqueFileName = $uniquePrefix . '_' . $fileName;
         
         $publicDirectory = public_path('images');
         if (!File::exists($publicDirectory)) {
             File::makeDirectory($publicDirectory, 0755, true);
         }
         $destinationPath = $publicDirectory . DIRECTORY_SEPARATOR . $uniqueFileName;
         File::copy($filePath, $destinationPath);
         return 'images/' . $uniqueFileName;
     }
     private function moveToPublicDirectoryError($filePath)
     {
         $fileName = pathinfo($filePath, PATHINFO_BASENAME); 
         $destinationPath = public_path('images') . DIRECTORY_SEPARATOR . $fileName;
         if (File::exists($destinationPath)) {
             File::delete($destinationPath);
         }
 
         File::copy($filePath, $destinationPath);
         return 'images/' . $fileName;
     }
}
