<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\WorkFlow;
use Illuminate\Http\Request;

class CreateImage extends Controller
{
    //
    public function ShowWorkFlow()
    {
        $workflow = WorkFlow::paginate(6);
        return view("User.CreateImage.ShowAllCreateImage", compact("workflow"));
    }
}
