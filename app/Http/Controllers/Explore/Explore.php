<?php

namespace App\Http\Controllers\Explore;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class Explore extends Controller
{
    public function ShowExplore(Request $request)
    {
        $query = Photo::query();
        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }
        $photos = $query->paginate($request->limit ?? 10);
        return view("User.Explore.Explore", compact('photos'));
    }
}
