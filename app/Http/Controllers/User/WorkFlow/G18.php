<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class G18 extends Controller
{
    use AI_Create_Image;
    public function InputDataG18()
    {
        return $this->InputData(18);
    }

    public function ShowImageG18(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(18)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

        $Email = Cookie::get("token_account");
        $prompt = $request->input("prompt");
        $seed = $request->input("seed");
        $model = $this->ChooseModel($request->input("model"));

        $translated = $this->Translate2English($prompt);

        $process = json_decode(file_get_contents(storage_path('app/G18.json')), true);
        $model = $this->ChooseModel2($request->input("model"));

        $process["22"]["inputs"]["lora_name"] = $model;
        $process["8"]["inputs"]["text"] = $translated;
        $process["8"]["inputs"]["noise_seed"] = $seed;

        $imageUrl = $this->get_image_result($process, 19);

        try {
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$Email}/{$takeImageUrl}";
            $this->storeImageHistory($url);
            Cookie::queue("url", $url);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", $request->input("model"));
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg18")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("url", $imageUrl);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", $request->input("model"));
            Cookie::queue("prompt", $prompt);
            return response()->json(['success' => true, 'redirect' => route("get_imageg18")]);
        }
    }
    public function get_imageG18()
    {
        return $this->ImageG(18);
    }
}
