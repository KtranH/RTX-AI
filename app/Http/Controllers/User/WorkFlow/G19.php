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

class G19 extends Controller
{
     //
     use AI_Create_Image;
     public function InputDataG19()
     {
        return $this->InputData(19);
     }
     public function ShowImageG19(Request $request)
     {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(19)->Price) == false)
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

         $process = json_decode(file_get_contents(storage_path('app/G19.json')), true);
         $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G19" . ".png";

         $process["34"]["inputs"]["text_b"] = $translated;
         $process["27"]["inputs"]["seed"] = $seed;
         $process["37"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

         $destinationPath = $this->inputDir . '/' . $email;
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
         }

         $request->file("input")->move($destinationPath, $main);

         try {
             $imageUrl = $this->get_image_result($process, 38);
             $takeImageUrl = $this->UploadImageR2($imageUrl);
             $url = $this->urlR2 . "AIimages/{$email}/{$takeImageUrl}";
             $this->storeImageHistory($url);
             Cookie::queue("url", $url);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", "Tạo nền background cho sản phẩm");
             Cookie::queue("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg19")]);
         } catch (Exception $e) {
             $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
             Cookie::queue("url", $imageUrl);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", "Tạo nền background cho sản phẩm");
             Cookie::queue("prompt", $request->input("prompt"));
             return response()->json(['success' => true, 'redirect' => route("get_imageg19")]);
         }
     }
    public function get_imageG19()
    {
        return $this->ImageG(19);
    }
     
}
