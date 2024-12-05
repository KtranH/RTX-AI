<?php

namespace App\Http\Controllers\Admin\Account;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\AdminAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Information extends Controller
{
    //
    use AI_Create_Image;
    public function ShowInformation()
    {
        return view('Admin.Account.Information');
    }
    public function UpdateInformation(Request $request)
    {
       try
       {
            AdminAccount::where('id', Auth::guard('admin')->user()->id)->update([
                'username' => $request->username,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : Auth::guard('admin')->user()->password,
                'updated_at' => now()
            ]);
            return response()->json(['success' => true]);
       }
       catch(\Exception $e)
       {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
       }
    }
    public function UpdatePassword(Request $request)
    {
        try
        {
            AdminAccount::where('id', Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);
            return response()->json(['success' => true]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function UpdateAvatar(Request $request)
    {
        try
        {
            $email = Auth::guard('admin')->user()->email;  
            $avatar = $request->file('avatar');
            $filename = time() . '.' . $avatar->getClientOriginalExtension();
            $coverPath = "AvatarAdmin/{$email}/{$filename}";

            Storage::disk('r2')->put($coverPath, file_get_contents($avatar));

            AdminAccount::where('id', Auth::guard('admin')->user()->id)->update([
                'avatar_url' => $this->urlR2 . $coverPath,
                'updated_at' => now()
            ]);
            return response()->json(['success' => true, 'avatar' => $this->urlR2 . $coverPath]);
        }
        catch(\Exception $e)
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
