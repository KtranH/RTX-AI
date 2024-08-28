<?php

namespace App;

use App\Models\User;
use App\Models\WorkFlow;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Stichoza\GoogleTranslate\GoogleTranslate;

trait AI_Create_Image
{
    //
    private $check_text = ' are these words SENSITIVE or OBSCENE? Just answer YES or NO.';
    private $url = 'http://127.0.0.1:8188/prompt';
    private $url2 = 'http://192.168.1.10:8188/prompt';
    private $interrupt = '';
    private $inputDir = 'D:\AI\SD\ComfyUI_windows_portable\ComfyUI\input';
    private $inputError = 'D:\ProjectPHP\GradioApp\img';
    private $outputDir = '';
    public function InputData($ListG)
    {
        Session::forget("prompt");
        Session::forget("seed");
        Session::forget("url");

        $cookie = Cookie::get("token_account");
        $times = User::where("email",$cookie)->first();
        $ShowTimes = $times->times;
        $G = WorkFlow::find($ListG);
        $NameG = "G" . $ListG;
        return view("User.InputData_WorkFlow." . $NameG ,compact("ShowTimes","G"));
    }
    public function ImageG($ListG)
    {
        $prompt = Session::get("prompt");
        $model = Session::get("model");
        $seed = Session::get("seed");
        $url = Session::get("url");
        $G = WorkFlow::find($ListG);

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
    private function get_image($process, $numberOutput)
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
                    $image = 'http://127.0.0.1:8188/view?filename='.$takeFileName[$id]['outputs'][$numberOutput]['images'][0]['filename'];
                    break;
                }
            }
            else
            {
                break;
            }
            sleep(2);
        }
        return $image;
    }
    private function check_prompt($process)
    {
        $client = new Client();
        $response = $client->post($this->url2, [
            'json' => ['prompt' => $process]
        ]);

        if ($response->getStatusCode() == 200) 
        {
            $body = json_decode($response->getBody(), true);
            $id = $body['prompt_id'] ?? null;
        }

        while(true)
        {
            $response = $client->get('http://192.168.1.10:8188/history/' . $id);
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
                break;
            }
            sleep(2);
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
    private function Translate2English($prompt)
    {
        $translator = new GoogleTranslate();
        $translated = $translator->setSource('vi')->setTarget('en')->translate($prompt);
        return $translated;
    }
    private function ChooseModel($model)
    {
        if ($model == "Ảnh hình 3D") 
        {
            $model = "3DRedmond-3DRenderStyle-3DRenderAF.safetensors";
        } 
        else if ($model == "Ảnh hoạt hình") 
        {
            $model = "Anime Enhancer XL_v5.safetensors";
        } 
        return $model;
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
}
