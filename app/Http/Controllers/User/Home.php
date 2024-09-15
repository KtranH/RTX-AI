<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class Home extends Controller
{
    // Show the home page
    public function ShowHome()
    {
        $landscape = Category::where("name","like","%". "Phong cảnh". "%")->get();
        $animal = Category::where("name","=","Động vật")->get();
        $fashion = Category::where("name","like","%". "Thời trang". "%")->get();
        $city = Category::where("name","like","%". "Thành phố". "%")->get();
        $travel = Category::where("name","like","%". "Du lịch". "%")->get();
        $tech = Category::where("name","like","%". "Công nghệ". "%")->get();
        return view("User.Home.Home",compact("landscape","animal","fashion","city","travel","tech"));
    }
}
