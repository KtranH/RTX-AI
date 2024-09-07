<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class G2 extends Controller
{
     //
     use AI_Create_Image;
     public function InputDataG2()
     {
         return $this->InputData(2);
     }
 
     public function ShowImageG2(Request $request)
     {
        ini_set("max_execution_time",3600);

        $Email = Cookie::get("token_account");

        $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048',],
        ['input.max' => 'Dung lượng file không được vượt quá 4MB.',]);

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

        $translated = $this->Translate2English($prompt);

        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);

        $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;
        $answer = $this->check_prompt($process);

        $answer = stripos($answer,"No");
        if(!$answer)
        {
            Session::flash("SensitiveWord","checked");
            return redirect()->route("g2");
        }
 
        $process = json_decode(file_get_contents(storage_path('app/G2.json')), true);
 
        $model = $this->ChooseModel($model);
        
        $currentDate = Carbon::now();
        $main = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G2" .  $currentDate->format('Y-m-d') . ".png";
 
        $process["23"]["inputs"]["lora_name"] = $model;
        $process["3"]["inputs"]["text"] = $translated;
        $process["7"]["inputs"]["noise_seed"] = $seed;
        $process["15"]["inputs"]["image"] = $email . "/" . $main;

        $destinationPath = $this->inputDir . '/' . $email;
       
        if (!file_exists($destinationPath)) 
        {
             mkdir($destinationPath, 0777, true);
        }

        $image->move($destinationPath , $main);
 
        try 
        {
            $imageUrl = $this->get_image($process,14);
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";
            Session::put("url",$url);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg2")]); 
        } 
        catch (Exception $e) 
        {
            $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
            $publicPath = $this->moveToPublicDirectoryError($error_image_path);
            $imageUrl = asset($publicPath);
            Session::put("url",$imageUrl);
            Session::put("seed",$seed);
            Session::put("prompt",$prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg2")]); 
        }
    }
    public function get_image()
    {
        return $this->ImageG(2);
    }
     
}
