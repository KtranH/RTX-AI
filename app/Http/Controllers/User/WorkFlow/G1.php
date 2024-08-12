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
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;


class G1 extends Controller
{
    //
    private $url = 'http://127.0.0.1:8188/prompt';
    private $interrupt = 'http://127.0.0.1:8188/interrupt';
    private $inputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\input';
    private $inputError = 'D:\ProjectPHP\GradioApp\img';
    private $outputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\output';

    public function InputDataG1()
    {
        Session::forget("prompt");
        Session::forget("seed");
        Session::forget("url");

        $cookie = Cookie::get("token_account");
        $times = User::where("email",$cookie)->first();
        $ShowTimes = $times->times;
        $G = WorkFlow::find(1);
        return view("User.InputData_WorkFlow.G1",compact("ShowTimes","G"));
    }

    public function ShowImageG1(Request $request)
    {
        ini_set("max_execution_time",3600);
        
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");
        $model = $request->input("model");

        Session::put("model",$model);

        $translator = new GoogleTranslate();
        $translated = $translator->setSource('vi')->setTarget('en')->translate($prompt);
        
        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);

        $process["1"]["inputs"]["prompt"] = $translated . ". Are these words sensitive or obscene to children? Just answer yes or no.";
        $filePath = "D:\AI\SD\ComfyUI_windows_portable\ComfyUI\input\check_text.txt";
        
        $this->startQueue($process);

        $process = json_decode(file_get_contents(storage_path('app/G1.json')), true);

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

        $process["7"]["inputs"]["ckpt_name"] = $model;
        $process["8"]["inputs"]["text"] = $translated;
        $process["12"]["inputs"]["noise_seed"] = $seed;

        $previousImage = $this->getLatestImage($this->outputDir);
        $this->startQueue($process);

        try 
        {
            $latestImage = $this->waitForImage($previousImage);
            $publicPath = $this->moveToPublicDirectory($latestImage);
            $imageUrl = asset($publicPath);
            $check = file_get_contents($filePath);
            $no = stripos($check,"No");
            if(!$no)
            {
                Session::flash("SensitiveWord","checked");
                return redirect()->route("g1");
            }
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return redirect()->route("showg1");
        } 
        catch (Exception $e) 
        {
            $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
            $publicPath = $this->moveToPublicDirectoryError($error_image_path);
            $imageUrl = asset($publicPath);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return redirect()->route("showg1");
        }
    }

    public function ImageG1()
    {
        $prompt = Session::get("prompt");
        $model = Session::get("model");
        $seed = Session::get("seed");
        $url = Session::get("url");
        $G = WorkFlow::find(1);

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
