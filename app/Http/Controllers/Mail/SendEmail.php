<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use App\Mail\MyTestMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Catch_;

class SendEmail extends Controller
{
    //
    public function ShowAuth()
    {
        return view("User.Account.AuthEmail");
    }
    public function SendEmail()
    {
        try
        {
            $email = Session::get("email");
            $name = Session::get("username");
    
            $verificationCode = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(10);
    
            Session::put('verification_code', $verificationCode);
            Session::put('verification_code_expires_at', $expiresAt);
    
            $detail = [
                'title' => "Mã xác nhận từ RTX-AI",
                'begin' => "Xin chào " . $name,
                'body' => "Chúng tôi nhận được lượt đăng ký tài khoản của bạn. Nhập mã dưới đây để hoàn tất xác minh (Lưu ý mã chỉ có khả dụng trong 10 phút)",
                'code' => $verificationCode
            ];
    
            Mail::to($email)->send(new MyTestMail($detail));
    
            return redirect()->route("showauth");
        }
        catch(Exception $e)
        {
            return redirect()->route("showhome");
        }
    }
    public function ReSendEmail()
    {
        try
        {
            $email = Session::get("email");
            $name = Session::get("username");

            $lastSentAt = Session::get('last_verification_code_sent_at');

            if ($lastSentAt && Carbon::parse($lastSentAt)->diffInMinutes(Carbon::now()) < 10) {
                return response()->json(['message' => 'Vui lòng đợi 10 phút để gửi mã mới!']);
            }

            $verificationCode = rand(100000, 999999);
            $expiresAt = Carbon::now()->addMinutes(10);

            Session::put('verification_code', $verificationCode);
            Session::put('verification_code_expires_at', $expiresAt);
            Session::put('last_verification_code_sent_at', Carbon::now());

            $detail = [
                'title' => "Mã xác nhận từ RTX-AI",
                'begin' => "Xin chào " . $name,
                'body' => "Chúng tôi nhận được lượt đăng ký tài khoản của bạn. Nhập mã dưới đây để hoàn tất xác minh (Lưu ý mã chỉ có khả dụng trong 10 phút)",
                'code' => $verificationCode
            ];

            Mail::to($email)->send(new MyTestMail($detail));

            return response()->json(['message' => 'Đã gửi mã xác nhận!']);
        }
        catch(Exception $e)
        {
            return redirect()->route("showlogin");
        }
    }
    public function CheckCode(Request $request)
    {
        $code = $request->input("input-code");
        
        if(empty($code))
        {
            Session::flash("EmptyCode","checked");
            return redirect()->route("showauth");
        }
        else
        {
            $verificationCode = Session::get('verification_code');
            $expiresAt = Session::get('verification_code_expires_at');
            if ($verificationCode && $expiresAt && $verificationCode == $code && Carbon::now()->lessThanOrEqualTo($expiresAt)) 
            {
                Session::forget('verification_code');
                Session::forget('verification_code_expires_at');
                Session::forget('last_verification_code_sent_at');

                $name = Session::get("username");
                $email = Session::get("email");
                $pass = Session::get("password");

                Session::forget('username');
                Session::forget('email');
                Session::forget('password');
            
                $url = env('R2_URL') . '/' . "default_avatar.jpg";
            
                DB::table("users")->insert([
                    "username" => $name,
                    "email" => $email,
                    "password" =>  Hash::make($pass),
                    "avatar_url" =>  $url,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);

                $cookie = Cookie::make("token_account", $email, 3600 * 24 * 30);
                return redirect()->route("showhome")->withCookie($cookie);
            } 
            else 
            {
                Session::flash("ExpiredCode","checked");
                return redirect()->route("showauth");
            }
        }
    }
}
