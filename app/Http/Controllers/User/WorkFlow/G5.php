<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class G5 extends Controller
{
    //
    use AI_Create_Image;
     public function InputDataG5()
     {
         return $this->InputData(5);
     }
     public function ShowImageG5(Request $request)
     {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(1) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

         $email = Cookie::get("token_account");

         $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048'], 
         ['input.max' => 'Dung lượng file không được vượt quá 4MB.']);

         if (!$request->hasFile("input")) {
             return redirect()->route("showworkflow");
         }

         $seed = $request->input("seed");

         $process = json_decode(file_get_contents(storage_path('app/G5.json')), true);
         $model = $this->ChooseModel($request->input("model"));
         $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G5" . ".png";

         $process["6"]["inputs"]["noise_seed"] = $seed;
         $process["14"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

         $destinationPath = $this->inputDir . '/' . $email;
         if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
         }

         $request->file("input")->move($destinationPath, $main);

         try {
             $imageUrl = $this->get_image_result($process, 13);
             $takeImageUrl = $this->UploadImageR2($imageUrl);
             $url = $this->urlR2 . "AIimages/{$email}/{$takeImageUrl}";
             Cookie::queue("url", $url);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", "Hoạt hình Anime");
             Cookie::queue("prompt", "Chuyển đổi ảnh thường sang anime");
             return response()->json(['success' => true, 'redirect' => route("get_imageg5")]);
         } catch (Exception $e) {
             $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
             Cookie::queue("url", $imageUrl);
             Cookie::queue("seed", $seed);
             Cookie::queue("model", "Hoạt hình Anime");
             Cookie::queue("prompt", "Chuyển đổi ảnh thường sang anime");
             return response()->json(['success' => true, 'redirect' => route("get_imageg5")]);
         }
     }
    public function get_imageG5()
    {
        return $this->ImageG(5);
    }
}
