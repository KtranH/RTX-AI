<?php

namespace App\Http\Controllers\Explore;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Explore extends Controller
{
    public function ShowExplore(Request $request)
    {
        $categories = Category::take(18)->get();
        
        $suggestCategories = DB::table("category_photo")->select("photo_id", "category_id")->inRandomOrder()->limit(6)->get();
        for ($i = 0; $i < 6; $i++) {
            $suggest[$i]["category"] = Category::find($suggestCategories[$i]->category_id)->name;
            $suggest[$i]["photo"] = Photo::find($suggestCategories[$i]->photo_id)->url;
        }
        return view("User.Explore.Explore", compact('categories', 'suggest'));
    }

    public function indexApi(Request $request)
    {
        // DB::listen(function ($query) {
        //     \Log::info('SQL Query: ' . $query->sql);
        //     \Log::info('Bindings: ' . implode(', ', $query->bindings));
        //     \Log::info('Time: ' . $query->time . 'ms');
        // });

        $query = Photo::query()
            ->leftJoin('albums', 'albums.id', '=', 'photos.album_id')
            ->leftJoin('users', 'users.id', '=', 'albums.user_id')
            ->select('photos.*', 'users.avatar_url as avatar_user', 'users.username as name_user')
            ->withCount('likes');

        if ($request->has('q')) {
            $query->where('photos.title', 'like', '%' . $request->q . '%');
        }

        $photos = $query->paginate($request->limit ?? 8);
        return response()->json($photos);
    }
    public function MoreCategory()
    {
        $ResultABC = [];

        foreach (range('A', 'Z') as $letter) {
            $queryResult = DB::table('categories')
                ->where(DB::raw('LOWER(SUBSTRING(name, 1, 1))'), strtolower($letter))
                ->get();

            if ($queryResult->isNotEmpty()) {
                $results[$letter] = $queryResult;
            }
        }

        return view('User.Explore.MoreCategory', compact('results'));
    }
}
