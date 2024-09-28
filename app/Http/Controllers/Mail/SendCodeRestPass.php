<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\CodeRestPass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendCodeRestPass extends Controller
{
    //
    public function SendCodeToEmail()
    {
        try
        {
            $email = Session::get("CodeRestPass");

            $verificationCode = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(10);
    
            Session::put('verification_code', $verificationCode);
            Session::put('verification_code_expires_at', $expiresAt);
    
            $detail = [
                'title' => "Mã xác nhận từ RTX-AI",
                'begin' => "Xin chào " . $email,
                'body' => "Chúng tôi nhận được yêu cầu đổi mật khẩu của bạn. Nhập mã dưới đây để hoàn tất đổi mật khẩu (Lưu ý mã chỉ tồn tại trong 10 phút)",
                'code' => $verificationCode
            ];
    
            Mail::to($email)->send(new CodeRestPass($detail));
    
            return redirect()->route("inputcodetochangepass");
        }
        catch(Exception $e)
        {
            return redirect()->route("showhome");
        }
    }
    public function InputCodeToChangePass()
    {
        return View("User.Account.InputCodeToChangePass");
    }
    public function CheckCodeToChangePass(Request $request)
    {
        $request->validate([
            'input-code' => 'required|string|max:255',
            'input-pass' => 'required|string|min:8',
            'input-pass2' => 'required|string|min:8',
        ], [
            'input-code.required' => 'Vui lòng nhập mã xác nhận',
            'input-code.max' => 'Mã xác nhận phải nhỏ hơn 255 ký tự',
            'input-pass.required' => 'Vui lòng nhập Password',
            'input-pass.min' => 'Password phải nhiều hơn 8 ký tự',
            'input-pass2.required' => 'Vui lòng nhập lại Password',
            'input-pass2.min' => 'Password phải nhiều hơn 8 ký tự',
        ]);

        $code = $request->input("input-code");
        $pass = $request->input("input-pass");
        $pass2 = $request->input("input-pass2");

       
        if($pass != $pass2)
        {
            Session::flash("ErrorPass","checked");
            return redirect()->route("inputcodetochangepass");
        }

        $verificationCode = Session::get('verification_code');
        $expiresAt = Session::get('verification_code_expires_at');

        if ($verificationCode && $expiresAt && $verificationCode == $code && Carbon::now()->lessThanOrEqualTo($expiresAt)) 
        {
            Session::forget('verification_code');
            Session::forget('verification_code_expires_at');

            $email = Session::get("CodeRestPass");

            Session::forget("CodeRestPass");
                
            DB::table("users")->where("email",$email)->update(["password" => Hash::make($pass)]);

            return redirect()->route("showlogin");
        } 
        else 
        {
            Session::flash("ExpiredCode","checked");
            return redirect()->route("inputcodetochangepass");
        }
    }
}
