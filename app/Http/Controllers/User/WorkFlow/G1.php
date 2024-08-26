<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class G1 extends Controller
{
    use AI_Create_Image;
    public function InputDataG1()
    {
        return $this->InputData(1);
    }

    public function ShowImageG1(Request $request)
    {
        ini_set("max_execution_time",3600);
        
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");
        $model = $request->input("model");

        Session::put("model",$model);

        $translated = $this->Translate2English($prompt);
        
        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);

        $process["1"]["inputs"]["prompt"] = $translated . $this->check_text;
        
        $answer = $this->check_prompt($process);

        $answer = stripos($answer,"No");

        if(!$answer)
        {
            Session::flash("SensitiveWord","checked");
            return redirect()->route("g1");
        }

        $process = json_decode(file_get_contents(storage_path('app/G1.json')), true);

        $model = $this->ChooseModel($model);

        $process["20"]["inputs"]["lora_name"] = $model;
        $process["8"]["inputs"]["text"] = $translated;
        $process["12"]["inputs"]["noise_seed"] = $seed;
       
        try 
        {
            $imageUrl = $this->get_image($process,19);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return $this->ImageG(1);
        } 
        catch (Exception $e) 
        {
            $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
            $publicPath = $this->moveToPublicDirectoryError($error_image_path);
            $imageUrl = asset($publicPath);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return $this->ImageG(1);
        }
    }
}
