<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;


class G7 extends Controller
{
    use AI_Create_Image;
    public function InputDataG7()
    {
        return $this->InputData(7);
    }
    public function ShowImageG7(Request $request)
    {
        ini_set("max_execution_time", 3600);

        if($this->checkTimes(WorkFlow::findOrFail(7)->Price) == false)
        {
            return response()->json(['success' => false, 'message' => 'Bạn đã hết lượt tạo ảnh, vui lòng mua thêm lượt hoặc đợi ngày mai']);
        }
        $email = Cookie::get("token_account");

        $request->validate(['input' => 'image|mimes:jpg,jpeg,png|max:4048'], 
        ['input.max' => 'Dung lượng file không được vượt quá 4MB.']);

        if (!$request->hasFile("input")) {
            return redirect()->route("showworkflow");
        }

        $process = json_decode(file_get_contents(storage_path('app/G7.json')), true);
        $main = $email . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "G7" . ".png";

        $process["12"]["inputs"]["image"] = $this->inputDir . '/' . $email . "/" . $main;

        $destinationPath = $this->inputDir . '/' . $email;
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $request->file("input")->move($destinationPath, $main);

        try {
            $text_result = $this->get_text_result($process);
            $text_result = $this->Translate2Vietnamese($text_result);
            Cookie::queue("url", "images/INPUT_AI/hoangkhoi230@gmail.com/" . $main);
            Cookie::queue("seed", null);
            Cookie::queue("model", "Phân tích ảnh");
            Cookie::queue("prompt", $text_result);
            return response()->json(['success' => true, 'redirect' => route("get_imageg7")]); 
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Cookie::queue("seed", null);
            Cookie::queue("model", "Phân tích ảnh");
            return response()->json(['success' => true, 'redirect' => route("get_imageg7")]);
        }
    }
    public function get_imageG7()
    {
        return $this->ImageG(7);
    }
}
