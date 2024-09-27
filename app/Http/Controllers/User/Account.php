<?php

namespace App\Http\Controllers\User;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;

class Account extends Controller
{
    //
    use AI_Create_Image;
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
        try {
            $user = Socialite::driver("google")->user();
            $email = $user->getEmail();
            $name = $user->getName();
            $avatar = $user->getAvatar();

            $existingUser = User::where("email", $email)->first();
            if (!$existingUser) {
                User::create([
                    "username" => $name,
                    "email" => $email,
                    "password" => Hash::make("20012158840792030230440707349054"),
                    "avatar_url" => $avatar,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);
            }
            $cookie = Cookie::make("token_account", $email, 3600 * 24 * 30);
            Auth::attempt(["email" => $email, "password" => "123"], true);
            return redirect()->route("showhome")->withCookie($cookie);
        } catch (Exception $e) {
            return redirect()->route("showlogin");
        }
    }
    public function Logout()
    {
        Cookie::queue(Cookie::forget("token_account"));
        Auth::logout();
        return redirect()->route("showhome");
    }
    public function NewAccount(Request $request)
    {
        $request->validate([
            'input-name' => 'required|string|max:255',
            'input-email' => 'required|string|email|max:255|unique:users',
            'input-pass' => 'required|string|min:8',
            'input-pass2' => 'required|string|min:8',
        ], [
            'input-name.required' => 'Vui lòng nhập tên người dùng',
            'input-name.max' => 'Tên người dùng phải nhỏ hơn 255 ký tự',
            'input-email.required' => 'Vui lòng nhập email',
            'input-email.email' => 'Email phải là email',
            'input-email.max' => 'Email phải nhỏ hơn 255 ký tự',
            'input-email.unique' => 'Email đã tồn tại',
            'input-pass.required' => 'Vui lòng nhập Password',
            'input-pass.min' => 'Password phải nhiều hơn 8 ký tự',
            'input-pass2.required' => 'Vui lòng nhập lại Password',
            'input-pass2.min' => 'Password phải nhiều hơn 8 ký tự',
        ]);

       $name = $request->input("input-name");
       $email = $request->input("input-email");
       $password = $request->input("input-pass");
       $password2 = $request->input("input-pass2");

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
    public function LoginAccount(Request $request)
    {
        $request->validate([
            'input-email' => 'required|string|email|max:255',
            'input-pass' => 'required|string|min:8',
        ], [
            'input-email.required' => 'Vui lòng nhập Email',
            'input-email.email' => 'Email phải là email',
            'input-email.max' => 'Email phải nhỏ hơn 255 ký tự',
            'input-pass.required' => 'Vui lòng nhập Password',
            'input-pass.min' => 'Password phải nhiều hơn 8 ký tự',
        ]);
        $email = $request->input("input-email");
        $pass = $request->input("input-pass");
        $CheckEmail = User::where("email",$email)->first();
        if($CheckEmail == null || !Hash::check($pass,$CheckEmail->password))
        {
            Session::flash("ErrorAccount","checked");
            return redirect()->route("showlogin");
        }
        else
        {
            $cookie = Cookie::make("token_account", $email, minutes: 3600 * 24 * 30);
            Auth::attempt(["email" => $email, "password" => $pass], true);
            return redirect()->route("showhome")->withCookie($cookie);
        }
    }
    public function ForgetPass()
    {
        return view("User.Account.ForgetPass");
    }
    public function SendEmailResetPass(Request $request)
    {
        $request->validate([
            'input-email' => 'required|string|email|max:255',
        ], [
            'input-email.required' => 'Vui lòng nhập Email',
            'input-email.email' => 'Email phải là email',
            'input-email.max' => 'Email phải nhỏ hơn 255 ký tự',
        ]);
        $email = $request->input("input-email");
        Session::put("CodeRestPass",$email);
        return redirect()->route("sendcodetoemail");
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
    public function UpdateAccount(Request $request)
    {
        $Email = Cookie::get("token_account");
        $request->validate([
            'avatar_url' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',
            'username' => 'required|string|max:255',
        ], [
            'avatar_url.image' => 'Ảnh đại diện phải là ảnh',
            'avatar_url.max' => 'Ảnh đại diện phải nhỏ hơn 4MB',
            'username.required' => 'Tên người dùng không được để trống',
            'username.max' => 'Tên người dùng không được quá 255 ký tự',
        ]);

        $user = User::where("email", Cookie::get("token_account"))->first();
        if ($user) {
            $user->username = $request->input("username");
            if ($image = $request->file("avatar_url")) {
                $filename = time() . '.' . $image->getClientOriginalExtension();
                Storage::disk('r2')->put("AvatarUser/{$user->email}/{$filename}", file_get_contents($image));
                Storage::disk('r2')->delete(str_replace($this->urlR2, "", $user->avatar_url));
                $user->avatar_url = $this->urlR2 . "AvatarUser/{$user->email}/{$filename}";
            }
            $user->update(['username' => $user->username, 'avatar_url' => $user->avatar_url]);
        }

        return redirect()->route("showaccount");
    }
}
