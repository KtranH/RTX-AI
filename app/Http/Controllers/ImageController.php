<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Stichoza\GoogleTranslate\GoogleTranslate;

class ImageController extends Controller
{
    private $url = 'http://127.0.0.1:8188/prompt';
    private $inputDir = '';
    private $inputError = '';
    private $outputDir = '';

    public function generateImage(Request $request)
    {

        $Positive_Prompt = $request->input('Positive_Prompt');
        $Height = $request->input('Height');
        $Width = $request->input('Width');
        $seed = $request->input('seed');
        $model = $request->input('model');
        $Load_VAE = $request->input('Load_VAE');

        $translator = new GoogleTranslate();
        $translated = $translator->setSource('vi')->setTarget('en')->translate($Positive_Prompt);

        $prompt = json_decode(file_get_contents(storage_path('app/workflow_api_2.json')), true);
        if ($model == "Hình ảnh thực tế") {
            $model = "majicmixRealistic_v7.safetensors";
        } elseif ($model == "Hình ảnh 3D") {
            $model = "majicmixLux_v3.safetensors";
        } elseif ($model == "Hình ảnh Realistic") {
            $model = "xxmix9realistic_v40.safetensors";
        } else {
            $model = "chosenMix_chosenMix.ckpt";
        }
            
        $prompt["3"]["inputs"]["seed"] = $seed;
        $prompt["4"]["inputs"]["ckpt_name"] = $model;
        $prompt["5"]["inputs"]["height"] = $Height;
        $prompt["5"]["inputs"]["width"] = $Width;
        $prompt["6"]["inputs"]["text"] = $translated;
        $prompt["10"]["inputs"]["vae_name"] = $Load_VAE;

        $previousImage = $this->getLatestImage($this->outputDir);

        $client = new Client();
        $response = $client->post($this->url, [
            'json' => ['prompt' => $prompt]
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
                    dd('http://127.0.0.1:8188/view?filename='.$takeFileName[$id]['outputs'][12]['images'][0]['filename']);
                }
            }
            else
            {
                break;
            }
            sleep(0.5);
        }
            
        try {
            $latestImage = $this->waitForImage($previousImage);
            $publicPath = $this->moveToPublicDirectory($latestImage);
            $imageUrl = asset($publicPath);
            $response = $client->get('http://127.0.0.1:8188/history/' . $id);
            if ($response->getStatusCode() == 200) 
            {
                $takeFileName = json_decode($response->getBody()->getContents(), true);
                dd($takeFileName);
            }
            return view('generate_image', ['imageUrl' => $imageUrl]);
        } catch (Exception $e) {
            $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
            $publicPath = $this->moveToPublicDirectoryError($error_image_path);
            $imageUrl = asset($publicPath);
            return view('generate_image', ['imageUrl' => $imageUrl]);
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

    /*private function startQueue($prompt)
    {
        $client = new Client();
        $response = $client->post($this->url, [
            'json' => ['prompt' => $prompt]
        ]);
    }*/

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
