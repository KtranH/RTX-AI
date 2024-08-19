<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Illuminate\Http\Request;

class Image extends Controller
{
    public function ShowWorkFlow()
    {
        $workflow = WorkFlow::paginate(6);
        return view("User.Image.Creativity", compact("workflow"));
    }

    public function CreateImage()
    {
        return view("User.Image.CreateImage");
    }
}
