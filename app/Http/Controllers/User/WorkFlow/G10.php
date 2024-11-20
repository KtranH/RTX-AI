<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class G10 extends Controller
{
    use AI_Create_Image;
    public function InputDataG10()
    {
        return $this->InputData(10);
    }

    public function ShowImageG10(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(10)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

        $Email = Cookie::get("token_account");
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");

        $translated = $this->Translate2English($prompt);
    
        $process = json_decode(file_get_contents(storage_path('app/G10.json')), true);
        $process["17"]["inputs"]["text_b"] = $translated;
        $process["6"]["inputs"]["noise_seed"] = $seed;

        $imageUrl = $this->get_image_result($process, 13);

        try {
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";
            $this->storeImageHistory($url);
            Cookie::queue("url", $url);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", "Tạo ảnh siêu thực");
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg10")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("url", $imageUrl);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", $request->input("model"));
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg10")]);
        }
    }
    public function get_imageG10()
    {
        return $this->ImageG(10);
    }
}
