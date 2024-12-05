<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class G11 extends Controller
{
    use AI_Create_Image;
    public function InputDataG11()
    {
        return $this->InputData(11);
    }
    public function ShowImageG11(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(11)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }
        $email = Cookie::get("token_account");

        $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048'], 
        ['input.max' => 'Dung lượng file không được vượt quá 4MB.']);

        if (!$request->hasFile("input")) {
            return redirect()->route("showworkflow");
        }

        $process = json_decode(file_get_contents(storage_path('app/G11.json')), true);
        $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G11" . ".png";

        $process["103"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

        $destinationPath = $this->inputDir . '/' . $email;
        if (!file_exists($destinationPath)) {
             mkdir($destinationPath, 0777, true);
         }

        $request->file("input")->move($destinationPath, $main);

        try {
            $imageUrl = $this->get_image_result($process, numberOutput: 104);
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = $this->urlR2 . "AIimages/{$email}/{$takeImageUrl}";
            $this->storeImageHistory($url);
            Cookie::queue("url", $url);
            Cookie::queue("seed", null);
            Cookie::queue("model", "Phân tích làm nét ảnh");
            Cookie::queue("prompt", null);
            return response()->json(['success' => true, 'redirect' => route("get_imageg11")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("seed", null);
            Cookie::queue("model", "Phân tích làm nét ảnh");
            return response()->json(['success' => true, 'redirect' => route("get_imageg11")]);
        }
    }
    public function get_imageG11()
    {
        return $this->ImageG(11);
    }
}
