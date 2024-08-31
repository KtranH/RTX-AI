<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class Account extends Controller
{
    //
    public function ShowLogin()
    {
        return view("User.Account.Login");
    }
    public function ShowSignUp()
    {
        return view("User.Account.SignUp");
    }
    public function loginByGoogle()
    {
        return Socialite::driver("google")->redirect();
    }
    public function callBackGoogle()
    {
        try
        {
            $user = Socialite::driver("google")->user();
            $email = $user->getEmail();
            $name = $user->getName();
            $avatar = $user->getAvatar();

            $checkUser = User::where("email",$email)->exists();
            if(!$checkUser)
            {
                DB::table("users")->insert([
                    "username" => $name,
                    "email" => $email,
                    "password" =>  Hash::make("20012158840792030230440707349054"),
                    "avatar_url" =>  $avatar,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
                $cookie = Cookie::make("token_account", $email, 3600 * 24 * 30);
                return redirect()->route("showhome")->withCookie($cookie);
            }
            else
            {
                $user = User::find($email);
                if($user)
                {
                    $user->avatar_url = $avatar;
                    $user->save();
                }
                $cookie = Cookie::make("token_account", $email, 3600 * 24 * 30);
                return redirect()->route("showhome")->withCookie($cookie);
            }
        }
        catch(Exception $e)
        {
            return redirect()->route("showlogin");
        }
    }
    public function Logout()
    {
        Cookie::queue(Cookie::forget("token_account"));
        return redirect()->route("showhome");
    }
    public function NewAccount(Request $request)
    {
       $name = $request->input("input-name");
       $email = $request->input("input-email");
       $password = $request->input("input-pass");
       $password2 = $request->input("input-pass2");
       if(empty($name))
       {
            Session::flash("EmptyName","checked");
       }
       else if(empty($email))
       {
            Session::flash("EmptyEmail","checked");
       }
       else if(empty($password))
       {
            Session::flash("EmptyPass","checked");
       }
       else if(empty($password2))
       {
            Session::flash("EmptyPass2","checked");
       }
       else
       {
            $errorName = User::where("username",$name)->exists();
            $errorEmail = User::where("email",$email)->exists();
            if($errorName)
            {
                Session::flash("ErrorName","checked");
            }
            else if($errorEmail)
            {
                Session::flash("ErrorEmail","checked");
            }
            else if($password != $password2)
            {
                Session::flash("ErrorPass","checked");
            }
            else
            {
               Session::put("username",$name);
               Session::put("email",$email);
               Session::put("password",$password);
               return redirect()->route("sendemail");
            }
        }
        return redirect()->route("showsignup");
    }
    public function LoginAccount(Request $request)
    {
        $email = $request->input("input-email");
        $pass = $request->input("input-pass");

        if(empty($email))
        {
            Session::flash("EmptyEmail","checked");
            return redirect()->route("showlogin");
        }
        else if(empty($pass))
        {
            Session::flash("EmptyPass","checked");
            return redirect()->route("showlogin");
        }
        else
        {
            $CheckEmail = User::where("email",$email)->first();
            if($CheckEmail == null || !Hash::check($pass,$CheckEmail->password))
            {
                Session::flash("ErrorAccount","checked");
                return redirect()->route("showlogin");
            }
            else
            {
                $cookie = Cookie::make("token_account", $email, 3600 * 24 * 30);
                return redirect()->route("showhome")->withCookie($cookie);
            }
        }
    }
    public function ForgetPass()
    {
        return view("User.Account.ForgetPass");
    }
    public function SendEmailResetPass(Request $request)
    {
        $email = $request->input("input-email");

        if(empty($email))
        {
            Session::flash("EmptyEmail","checked");
            return redirect()->route("forgetpass");
        }
        else
        {
            Session::put("CodeRestPass",$email);
            return redirect()->route("sendcodetoemail");
        }
    }

    public function ShowAccount()
    {
        $cookie = request()->cookie("token_account");
        
        if ($cookie) 
        {
            $tab = request()->query('tab', 'saved');
            return view('User.Account.Account', ['tab' => $tab]);
        } 
        else 
        {
            return redirect()->route('showlogin');
        }
    }
    public function ConfirmChangePass()
    {
        //This function is used to check the password change confirmation interface
        return view("User.Account.ConfirmChangePass");
    }
    public function ChangePass()
    {
        $email = Cookie::get("token_account");
        Session::put("CodeRestPass",$email);
        return redirect()->route("sendcodetoemail");
    }
}
