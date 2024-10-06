<?php

namespace App;

use App\Models\User;
use App\Models\WorkFlow;
use GuzzleHttp\Client;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

trait AI_Create_Image
{
    //
    use QueryDatabase;
    private $urlR2 = 'https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/';
    private $check_text = ' are these words SENSITIVE or OBSCENE? Just answer YES or NO.';
    private $url = 'http://127.0.0.1:8188/api/prompt';
    private $url2 = 'http://192.168.1.11:8188/api/prompt';
    private $interrupt = '';
    private $inputDir = 'D:\ProjectPHP\DO_AN\public\images\INPUT_AI';
    private $inputError = 'D:\ProjectPHP\DO_AN\public\images';
    private $outputDir = '';
    public function InputData($ListG)
    {
        $cookie = Cookie::get("token_account");
        $times = User::where("email",$cookie)->first();
        $ShowTimes = $times->times;
        $Price = WorkFlow::find($ListG)->Price;
        $G = WorkFlow::find($ListG);
        $NameG = "G" . $ListG;
        return view("User.InputData_WorkFlow." . $NameG ,compact("ShowTimes","G" ,"Price"));
    }
    public function ImageG($ListG)
    {
        $prompt = Cookie::get("prompt");
        $model = Cookie::get("model");
        $seed = Cookie::get("seed");
        $url = Cookie::get("url");
        Cookie::forget("prompt");
        Cookie::forget("seed");
        Cookie::forget("url");
        Cookie::forget("model");
        $G = WorkFlow::find($ListG);

        if(empty($prompt) || empty($seed))
        {
            return redirect()->route("showworkflow");
        }
        else
        {    
            $this->storeImageHistory($url, $this->find_id());
            return view("User.InputData_WorkFlow.ShowG", compact("prompt", "seed", "url", "G", "model"));
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
    private function get_image_result($process, $numberOutput)
    {
        $client = new Client();
        $response = $client->post($this->url, ['json' => ['prompt' => $process]]);
        
        if ($response->getStatusCode() !== 200) return null;

        $id = json_decode($response->getBody(), true)['prompt_id'] ?? null;

        while (true) {
            $response = $client->get("http://127.0.0.1:8188/api/history/{$id}");
            if ($response->getStatusCode() === 200) {
                $takeFileName = json_decode($response->getBody()->getContents(), true);
                if (!empty($takeFileName)) {
                    return 'http://127.0.0.1:8188/api/view?filename=' . $takeFileName[$id]['outputs'][$numberOutput]['images'][0]['filename'];
                }
            }
            sleep(2);
        }
    }
    private function check_prompt($process)
    {
        $client = new Client();
        $response = $client->post($this->url2, ['json' => ['prompt' => $process]]);

        if ($response->getStatusCode() !== 200) return null;

        $id = json_decode($response->getBody(), true)['prompt_id'] ?? null;

        while (true) {
            $response = $client->get('http://192.168.1.11:8188/api/history/' . $id);
            if ($response->getStatusCode() === 200) {
                $takeFileName = json_decode($response->getBody()->getContents(), true);
                if (!empty($takeFileName)) {
                    return $takeFileName[$id]["outputs"][3]["string"][0];
                }
            }
            sleep(2);
        }
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
        $models = [
            "Ảnh hình 3D" => "3DRedmond-3DRenderStyle-3DRenderAF.safetensors",
            "Ảnh hoạt hình" => "Anime Enhancer XL_v5.safetensors"
        ];
        return $models[$model] ?? $model;
    }
    private function UploadImageR2($urlImage)
    {
        $response = Http::get($urlImage);
        $Email = Cookie::get("token_account");
        $timestamp = Carbon::now()->format('H-i-s');  

        $pathInR2 = "AIimages/{$Email}/{$timestamp}.png";

        if ($response->successful()) {
            Storage::disk('r2')->put($pathInR2, $response->body());
            return "{$timestamp}.png";
        }
        return null;
    }

    private function checkTimes($price)
    {
        $user = User::find($this->find_id());
        if($user->times - $price < 0)
        {
            return false;
        }
        else
        {
            $user->update(['times' => $user->times - $price]);
            return true;
        }
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
