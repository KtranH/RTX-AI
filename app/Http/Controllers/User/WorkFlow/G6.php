<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class G6 extends Controller
{
    use AI_Create_Image;
    public function InputDataG6()
    {
        return $this->InputData(6);
    }

    public function ShowImageG6(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(1) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

        $Email = Cookie::get("token_account");
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");

        $translated = $this->Translate2English($prompt);
        
        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);
        $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;

        if (stripos($this->check_prompt($process), "No") === false) {
            Session::flash("SensitiveWord", "checked");
            return response()->json(['success' => false, 'message' => 'Mô tả của bạn chứa từ khóa nhạy cảm! Không thể tạo ảnh']);
        }

        $process = json_decode(file_get_contents(storage_path('app/G6.json')), true);
        $process["22"]["inputs"]["text_a"] = $translated;
        $process["19"]["inputs"]["noise_seed"] = $seed;

        $imageUrl = $this->get_image_result($process, 20);

        try {
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";
            Cookie::queue("url", $url);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", $request->input("model"));
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg6")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("url", $imageUrl);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", $request->input("model"));
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg6")]);
        }
    }
    public function get_imageG6()
    {
        return $this->ImageG(6);
    }
}
