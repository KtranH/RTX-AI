<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class Settings extends Controller
{
    public function ShowSettings(Request $request, $id = null)
    {
        $tab = $request->route('tab');
        return view('User.Settings.Settings', ['tab' => $tab]);
    }

}
