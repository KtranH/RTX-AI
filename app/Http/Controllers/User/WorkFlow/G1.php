<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
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
        ini_set("max_execution_time", 3600);
        
        $Email = Cookie::get("token_account");
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");
        $model = $this->ChooseModel($request->input("model"));

        $translated = $this->Translate2English($prompt);
        
        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);
        $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;

        if (stripos($this->check_prompt($process), "No") === false) {
            Session::flash("SensitiveWord", "checked");
            return response()->json(['success' => false, 'message' => 'Mô tả của bạn chứa từ khóa nhạy cảm! Không thể tạo ảnh']);
        }

        $process = json_decode(file_get_contents(storage_path('app/G1.json')), true);
        $process["20"]["inputs"]["lora_name"] = $model;
        $process["8"]["inputs"]["text"] = $translated;
        $process["12"]["inputs"]["noise_seed"] = $seed;

        try {
            $imageUrl = $this->get_image_result($process, 19);
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";

            Session::put("url", $url);
            Session::put("seed", $seed);
            Session::put("model", $request->input("model"));
            Session::put("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg1")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Session::put("url", $imageUrl);
            Session::put("seed", $seed);
            Session::put("model", $request->input("model"));
            Session::put("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg1")]);
        }
    }
    public function get_imageG1()
    {
        return $this->ImageG(1);
    }
}
