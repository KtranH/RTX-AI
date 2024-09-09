<?php

namespace App\Http\Controllers\User\WorkFlow;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class G3 extends Controller
{
    //
    use AI_Create_Image;
    public function InputDataG3()
    {
        return $this->InputData(3);
    }
    public function ShowImageG3(Request $request)
    {
        ini_set("max_execution_time", 3600);

        $email = Cookie::get("token_account");

        $request->validate([
            "input" => 'image|mimes:jpg,jpeg,png|max:4048',
            "input2" => 'image|mimes:jpg,jpeg,png|max:4048',
        ], [
            'input.max' => 'Dung lượng file không được vượt quá 4MB.',
            'input2.max' => 'Dung lượng file không được vượt quá 4MB.',
        ]);

        if (!$request->hasFile("input") || !$request->hasFile("input2")) {
            return redirect()->route("showworkflow");
        }

        $translated = $this->Translate2English($request->input("prompt"));
        $seed = $request->input("seed");
        $model = $this->ChooseModel($request->input("model"));

        $process = json_decode(file_get_contents(storage_path('app/Check_Text.json')), true);
        $process["1"]["inputs"]["prompt"] = '"' . $translated . '"' . $this->check_text;

        if (stripos($this->check_prompt($process), "No") === false) {
            Session::flash("SensitiveWord", "checked");
            return response()->json(['success' => false, 'message' => 'Mô tả của bạn chứa từ khóa nhạy cảm! Không thể tạo ảnh']);
        }

        $process = json_decode(file_get_contents(storage_path('app/G3.json')), true);
        $currentDate = Carbon::now();
        $main = "{$email}_" . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input")->getClientOriginalName()) . "_G3_Main_" . $currentDate->format('Y-m-d') . ".png";
        $other = "{$email}_" . preg_replace("/[^a-zA-Z0-9]/", "_", $request->file("input2")->getClientOriginalName()) . "_G3_Other_" . $currentDate->format('Y-m-d') . ".png";

        $process["32"]["inputs"]["lora_name"] = $model;
        $process["2"]["inputs"]["text"] = $translated;
        $process["6"]["inputs"]["noise_seed"] = $seed;
        $process["33"]["inputs"]["image"] = "{$this->inputDir}/{$email}/{$main}";
        $process["34"]["inputs"]["image"] = "{$this->inputDir}/{$email}/{$other}";

        $destinationPath = "{$this->inputDir}/{$email}";
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $request->file("input")->move($destinationPath, $main);
        $request->file("input2")->move($destinationPath, $other);

        try {
            $imageUrl = $this->get_image_result($process, 13);
            $takeImageUrl = $this->UploadImageR2($imageUrl);
            $url = "{$this->urlR2}AIimages/{$email}/{$takeImageUrl}";

            Session::put("url", $url);
            Session::put("seed", $seed);
            Session::put("model", $request->input("model"));
            Session::put("prompt", $request->input("prompt"));
            return response()->json(['success' => true, 'redirect' => route("get_imageg3")]);
        } catch (Exception $e) {
            $imageUrl = asset($this->moveToPublicDirectoryError($this->inputError . DIRECTORY_SEPARATOR . "error.jpg"));
            Session::put("url", $imageUrl);
            Session::put("seed", $seed);
            Session::put("model", $request->input("model"));
            Session::put("prompt", $request->input("prompt"));
            return response()->json(['success' => true, 'redirect' => route("get_imageg3")]);
        }
    }
    public function get_imageG3()
    {
        return $this->ImageG(3);
    }
}
