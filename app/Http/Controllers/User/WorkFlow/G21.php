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

class G21 extends Controller
{
    //
    use AI_Create_Image;
    public function InputDataG21()
    {
        return $this->InputData(21);
    }
    public function ShowImageG21(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(21)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }

        $email = Cookie::get("token_account");

        $request->validate([
            "input" => 'image|mimes:jpg,jpeg,png|max:4048',
            "input2" => 'image|mimes:jpg,jpeg,png|max:4048',
        ], [
            'input.max' => 'Dung lượng file không được vượt quá 4MB.',
            'input2.max' => 'Dung lượng file không được vượt quá 4MB.',
        ]);

        if (!$request->hasFile("input") || !$request->hasFile("input2")) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập đầy đủ hình anh']);
        }

        $translated = $this->Translate2English($request->input("prompt"));
        $seed = $request->input("seed");

        $process = json_decode(file_get_contents(storage_path('app/G21.json')), true);
        $main = "{$email}_" . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "_G21_Main_" . ".png";
        $other = "{$email}_" . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input2")->getClientOriginalName()) . "_G21_Other_" . ".png";

        $process["21"]["inputs"]["text_a"] = $translated;
        $process["6"]["inputs"]["seed"] = $seed;
        $process["42"]["inputs"]["image"] = "{$this->inputDir}/{$email}/{$main}";
        $process["41"]["inputs"]["image"] = "{$this->inputDir}/{$email}/{$other}";

        $destinationPath = "{$this->inputDir}/{$email}";
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $request->file("input")->move($destinationPath, $main);
        $request->file("input2")->move($destinationPath, $other);

        try {
            $imageUrl = $this->get_image_result($process, 43);
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = "{$this->urlR2}AIimages/{$email}/{$takeImageUrl}";
            $this->storeImageHistory($url);
            Cookie::queue("url", $url);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", "Tạo người mẫu theo khuôn mặt");
            Cookie::queue("prompt", $request->input("prompt"));
            return response()->json(['success' => true, 'redirect' => route("get_imageg21")]);
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("url", $imageUrl);
            Cookie::queue("seed", $seed);
            Cookie::queue("model", "Tạo người mẫu theo khuôn mặt");
            Cookie::queue("prompt", $request->input("prompt"));
            return response()->json(['success' => true, 'redirect' => route("get_imageg21")]);
        }
    }
    public function get_imageG21()
    {
        return $this->ImageG(21);
    }
}
