<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class G3 extends Controller
{
    //
    use AI_Create_Image;
    public function InputDataG3()
    {
        return $this->InputData(3);
    }
    public function ShowImageG3(Request $request)
    {
       ini_set("max_execution_time",3600);

       $Email = Cookie::get("token_account");

       $email = Cookie::get("token_account");
       $pattern = "/[^a-zA-Z0-9]/";
       $replacement = "_";
       $email = preg_replace($pattern, $replacement, $email);

       $request->validate(["input" => 'image|mimes:jpg,jpeg,png|max:4048',],
       ['input.max' => 'Dung lượng file không được vượt quá 4MB.',]);
       $request->validate(["input2" => 'image|mimes:jpg,jpeg,png|max:4048',],
       ['input2.max' => 'Dung lượng file không được vượt quá 4MB.',]);

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

       $translated = $this->Translate2English($prompt);

       $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);

       $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;
       $answer = $this->check_prompt($process);

       $answer = stripos($answer,"No");
       if(!$answer)
       {
           Session::flash("SensitiveWord","checked");
           return redirect()->route("g3");
       }

       $process = json_decode(file_get_contents(storage_path('app/G3.json')), true);

       $model = $this->ChooseModel($model);

       $currentDate = Carbon::now();

       $other = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G3_Other" .  $currentDate->format('Y-m-d') . ".png";
       $main = $email . preg_replace($pattern,$replacement,$image->getClientOriginalName()) . "G3_Main" .  $currentDate->format('Y-m-d') . ".png";

       $process["32"]["inputs"]["lora_name"] = $model;
       $process["2"]["inputs"]["text"] = $translated;
       $process["6"]["inputs"]["noise_seed"] = $seed;
       $process["14"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;
       $process["20"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $other;

       $destinationPath = $this->inputDir . '/' . $email;
       
       if (!file_exists($destinationPath)) 
       {
            mkdir($destinationPath, 0777, true);
       }

       $image->move($destinationPath , $main);
       $image2->move($destinationPath, $other);

       try 
       {
           $imageUrl = $this->get_image_result($process,13);
           $takeImageUrl = $this->UploadImageR2($imageUrl);
           $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";
           Session::put("url",$url);
           Session::put("seed",$seed);
           Session::put("prompt",$prompt);
           return response()->json(['success' => true, 'redirect' => route("get_imageg3")]); 
       } 
       catch (Exception $e) 
       {
           $error_image_path = $this->inputError . DIRECTORY_SEPARATOR . "error.jpg";
           $publicPath = $this->moveToPublicDirectoryError($error_image_path);
           $imageUrl = asset($publicPath);
           Session::put("url",$imageUrl);
           Session::put("seed",$seed);
           Session::put("prompt",$prompt);
           return response()->json(['success' => true, 'redirect' => route("get_imageg3")]); 
       }
    }
    public function get_imageG3()
    {
        return $this->ImageG(3);
    }
}
