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


class G3 extends Controller
{
    //
    private $url = 'http://127.0.0.1:8188/prompt';
    private $interrupt = '';
    private $inputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\input';
    private $inputError = 'D:\ProjectPHP\GradioApp\img';
    private $outputDir = '';

    public function InputDataG3()
    {
        Session::forget("prompt");
        Session::forget("seed");
        Session::forget("url");

        $cookie = Cookie::get("token_account");
        $times = User::where("email",$cookie)->first();
        $ShowTimes = $times->times;
        $G = WorkFlow::find(2);
        return view("User.InputData_WorkFlow.G3",compact("ShowTimes","G"));
    }

    public function ShowImageG3(Request $request)
    {
       ini_set("max_execution_time",3600);

       $email = Cookie::get("token_account");
       $pattern = "/[^a-zA-Z0-9]/";
       $replacement = "_";
       $email = preg_replace($pattern, $replacement, $email);

       $request->validate(["input" => 'image|mimes:jpg,jpeg,png|max:4048',]);
       $request->validate(["input2" => 'image|mimes:jpg,jpeg,png|max:4048',]);

       $prompt = $request->input("prompt");
       $seed = $request->input("seed");
       $model = $request->input("model");
       $image = $request->file("input");
       $image2 = $request->file("input2");

       Session::put("model",$model);

       if(!$request->hasFile("input") || !$request->hasFile("input2"))
       {
           return redirect()->route("showworkflow");
       }

       $translator = new GoogleTranslate();
       $translated = $translator->setSource('vi')->setTarget('en')->translate($prompt);

       $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);

       $process["1"]["inputs"]["prompt"] = $translated . ". Are these words sensitive or obscene? Just answer yes or no.";
       $answer = $this->check_prompt($process);

       $answer = stripos($answer,"No");
       if(!$answer)
       {
           Session::flash("SensitiveWord","checked");
           return redirect()->route("g2");
       }

       $process = json_decode(file_get_contents(storage_path('app/G3.json')), true);

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

       $other = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G3_Other" .  $currentDate->format('Y-m-d') . ".png";
       $main = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G3_Main" .  $currentDate->format('Y-m-d') . ".png";

       $process["1"]["inputs"]["ckpt_name"] = $model;
       $process["2"]["inputs"]["text"] = $translated;
       $process["6"]["inputs"]["noise_seed"] = $seed;
       $process["14"]["inputs"]["image"] = $email . "/" . $main;
       $process["20"]["inputs"]["image"] = $email . "/" . $other;

       $destinationPath = $this->inputDir . '/' . $email;
       
       if (!file_exists($destinationPath)) 
       {
            mkdir($destinationPath, 0777, true);
       }

       $image->move($destinationPath , $main);
       $image2->move($destinationPath, $other);

       $previousImage = $this->getLatestImage($this->outputDir);

       try 
       {
           //$latestImage = $this->waitForImage($previousImage);
           //$publicPath = $this->moveToPublicDirectory($latestImage);
           //$imageUrl = asset($publicPath);
           $imageUrl = $this->get_image($process);
           Session::put("url",$imageUrl);
           Session::put("seed",$seed);
           Session::put("prompt",$prompt);
           return redirect()->route("showg3");
       } 
       catch (Exception $e) 
       {
           $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
           $publicPath = $this->moveToPublicDirectoryError($error_image_path);
           $imageUrl = asset($publicPath);
           Session::put("url",$imageUrl);
           Session::put("seed",$seed);
           Session::put("prompt",$prompt);
           return redirect()->route("showg3");
       }
    }

    public function ImageG3()
    {
        $prompt = Session::get("prompt");
        $model = Session::get("model");
        $seed = Session::get("seed");
        $url = Session::get("url");
        $G = WorkFlow::find(3);

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

    /*private function startQueue($prompt)
    {
        $client = new Client();
        $response = $client->post($this->url, [
            'json' => ['prompt' => $prompt]
        ]);
    }*/

    private function get_image($process)
    {
        $client = new Client();
        $response = $client->post($this->url, [
            'json' => ['prompt' => $process]
        ]);

        if ($response->getStatusCode() == 200) 
        {
            $body = json_decode($response->getBody(), true);
            $id = $body['prompt_id'] ?? null;
        }
        while(true)
        {
            $response = $client->get('http://127.0.0.1:8188/history/' . $id);
            if ($response->getStatusCode() == 200) 
            {
                $takeFileName = json_decode($response->getBody()->getContents(), true);
                if(!empty($takeFileName))
                {
                    $image = 'http://127.0.0.1:8188/view?filename='.$takeFileName[$id]['outputs'][13]['images'][0]['filename'];
                    break;
                }
            }
            else
            {
                break;
            }
            sleep(0.5);
        }
        return $image;
    }
    private function check_prompt($process)
    {
        $client = new Client();
        $response = $client->post($this->url, [
            'json' => ['prompt' => $process]
        ]);

        if ($response->getStatusCode() == 200) 
        {
            $body = json_decode($response->getBody(), true);
            $id = $body['prompt_id'] ?? null;
        }

        while(true)
        {
            $response = $client->get('http://127.0.0.1:8188/history/' . $id);
            if ($response->getStatusCode() == 200) 
            {
                $takeFileName = json_decode($response->getBody()->getContents(), true);
                if(!empty($takeFileName))
                {
                    $answer =  $takeFileName[$id]["outputs"][3]["string"][0];
                    break;
                }
            }
            else
            {
                $answer =  "Yes";
                break;
            }
            sleep(0.5);
        }
        return $answer;
    }

    private function waitForImage($previousImage)
    {
        while (true) {
            $latestImage = $this->getLatestImage($this->outputDir);
            if ($latestImage != $previousImage) {
                return $latestImage;
            }
            sleep(1.5);
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
