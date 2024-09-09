<?php

namespace App\Http\Controllers\Explore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Explore extends Controller
{
    public function ShowExplore()
    {
        return view("User.Explore.Explore");
    }
}
