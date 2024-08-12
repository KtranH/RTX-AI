<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;

class Board extends Controller
{
    public function ShowBoard()
    {
        $cookie = request()->cookie("token_account");
        
        if ($cookie) 
        {
            $tab = request()->query('tab', 'saved');
            return view('User.Board.Board', ['tab' => $tab]);
        } 
        else 
        {
            return redirect()->route('showlogin');
        }
    }
    
    public function CreateAlbum()
    {
        return view('User.Board.CreateAlbum');
    }
}
