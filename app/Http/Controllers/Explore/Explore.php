<?php

namespace App\Http\Controllers\Explore;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;

class Explore extends Controller
{
    public function ShowExplore(Request $request)
    {
        $categories = Category::all();

        return view("User.Explore.Explore", compact('categories'));
    }

    public function indexApi(Request $request)
    {
        $query = Photo::query();

        if ($request->has('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        $query->with('album.user', 'likes');
        $photos = $query->paginate($request->limit ?? 10);

        $photos->transform(function ($each) {
            $each->avatar_user = $each->album->user->avatar_url;
            $each->name_user = $each->album->user->username;
            $each->count_like = $each->likes->count();
            return $each;
        });

        return response()->json($photos);
    }
}
