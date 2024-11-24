<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class G16 extends Controller
{
     //
     use AI_Create_Image;
     public function InputDataG16()
     {
        return $this->InputData(16);
     }
     public function ShowImageG16(Request $request)
     {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(16)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

         $email = Cookie::get("token_account");

         $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048'], 
         ['input.max' => 'Dung lượng file không được vượt quá 4MB.']);

         if (!$request->hasFile("input")) {
             return redirect()->route("showworkflow");
         }

         $translated = $this->Translate2English($request->input("prompt"));
         $seed = $request->input("seed");

         $process = json_decode(file_get_contents(storage_path('app/G16.json')), true);
         $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G16" . ".png";

         $process["24"]["inputs"]["text_a"] = $translated;
         $process["9"]["inputs"]["seed"] = $seed;
         $process["23"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

         $destinationPath = $this->inputDir . '/' . $email;
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
         }

         $request->file("input")->move($destinationPath, $main);

         try {
             $imageUrl = $this->get_image_result($process, 25);
             $takeImageUrl = $this->UploadImageR2($imageUrl);
             $url = $this->urlR2 . "AIimages/{$email}/{$takeImageUrl}";
             $this->storeImageHistory($url);
             Cookie::queue("url", $url);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", "Tạo ảnh avatar 3D");
             Cookie::queue("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg16")]);
         } catch (Exception $e) {
             $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
             Cookie::queue("url", $imageUrl);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", $request->input("model"));
             Cookie::queue("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg16")]);
         }
     }
    public function get_imageG16()
    {
        return $this->ImageG(16);
    }
     
}
