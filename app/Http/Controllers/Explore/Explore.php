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
        $currentUserId = auth()->id();
        
        $query = Photo::query()
            ->leftJoin('albums', 'albums.id', '=', 'photos.album_id')
            ->leftJoin('users', 'users.id', '=', 'albums.user_id')
            ->distinct()
            ->join('category_photo', 'category_photo.photo_id', '=', 'photos.id')
            ->select('photos.*', 'users.avatar_url as avatar_user', 'users.username as name_user', 'users.id as user_id')
            ->with(['album.user'])
            ->withCount('likes');

        if ($currentUserId) {
            $query->leftJoin('follower_user', function($join) use ($currentUserId) {
                $join->on('users.id', '=', 'follower_user.user_id')
                    ->where('follower_user.follower_id', '=', $currentUserId);
            })
            ->addSelect(DB::raw('CASE 
                WHEN follower_user.user_id IS NOT NULL THEN 1 
                ELSE 0 
            END as is_following'));
        }
        if ($request->has('q')) {
            $searchTerm = $request->q;
            $query->where(function ($query) use ($searchTerm) {
                $query->where('photos.title', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('category', function ($query) use ($searchTerm) {
                        $query->where('name', $searchTerm);
                    })
                    ->orWhereHas('album.user', function ($query) use ($searchTerm) {
                        $query->where('username', 'like', '%' . $searchTerm . '%');
                    });
            });
        }

        if ($request->has('category')) {
            $query->where('category_photo.category_id', $request->category);
        }
        if ($currentUserId) {
            $query->orderByRaw('CASE 
                WHEN follower_user.user_id IS NOT NULL THEN 0 
                ELSE 1 
            END')
            ->orderBy('photos.created_at', 'desc');
        } else {
            $query->inRandomOrder();
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
