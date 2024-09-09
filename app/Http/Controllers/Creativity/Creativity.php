<?php

namespace App\Http\Controllers\Creativity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkFlow;

class Creativity extends Controller
{
    public function ShowCreativity()
    {
        $workflow = WorkFlow::paginate(6);
        return view("User.Creativity.Creativity", compact("workflow"));
    }
}
