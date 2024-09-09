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
         ini_set("max_execution_time", 3600);
         $email = Cookie::get("token_account");

         $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048'], 
         ['input.max' => 'Dung lượng file không được vượt quá 4MB.']);

         if (!$request->hasFile("input")) {
             return redirect()->route("showworkflow");
         }

         $translated = $this->Translate2English($request->input("prompt"));
         $seed = $request->input("seed");
         $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);
         $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;

         if (stripos($this->check_prompt($process), "No") === false) {
             Session::flash("SensitiveWord", "checked");
             return response()->json(['success' => false, 'message' => 'Mô tả của bạn chứa từ khóa nhạy cảm! Không thể tạo ảnh']);
         }

         $process = json_decode(file_get_contents(storage_path('app/G2.json')), true);
         $model = $this->ChooseModel($request->input("model"));
         $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G2" . Carbon::now()->format('Y-m-d') . ".png";

         $process["21"]["inputs"]["lora_name"] = $model;
         $process["3"]["inputs"]["text"] = $translated;
         $process["7"]["inputs"]["noise_seed"] = $seed;
         $process["33"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

         $destinationPath = $this->inputDir . '/' . $email;
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
         }

         $request->file("input")->move($destinationPath, $main);

         try {
             $imageUrl = $this->get_image_result($process, 14);
             $takeImageUrl = $this->UploadImageR2($imageUrl);
             $url = $this->urlR2 . "AIimages/{$email}/{$takeImageUrl}";
             Session::put("url", $url);
             Session::put("seed", $seed);
             Session::put("model", $request->input("model"));
             Session::put("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg2")]);
         } catch (Exception $e) {
             $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
             Session::put("url", $imageUrl);
             Session::put("seed", $seed);
             Session::put("model", $request->input("model"));
             Session::put("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg2")]);
         }
     }
    public function get_imageG2()
    {
        return $this->ImageG(2);
    }
     
}
