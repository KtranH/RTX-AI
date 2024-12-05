<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Settings extends Controller
{
    public function Index()
    {
        $user = Auth::user();
        $userPreferences = $user->preferences()->get();
        $categories = Category::all();
        $availableCategories = $categories->diff($userPreferences);
        return view('User.Settings.Settings', [
            'selectedCategories' => $userPreferences,
            'availableCategories' => $availableCategories,
        ]);
    }

    public function apiDataLiked()
    {
        $user = Auth::user();
        $likedPhotos = $user->likes()->with('photo')->paginate(4);
        return response()->json([
            'success' => true,
            'data' => $likedPhotos,
        ]);
    }
    public function apiDataAlbum()
    {
        $user = Auth::user();
        $albums = $user->albums()->paginate(4);
        return response()->json([
            'success' => true,
            'data' => $albums,
        ]);
    }

    public function apiDataFollow()
    {
        $user = Auth::user();
        $followings = $user->following()->paginate(4);
        return response()->json([
            'success' => true,
            'data' => $followings,
        ]);
    }

    public function storePreferences(Request $request)
    {
        try {
            $user = Auth::user();
            $newPreferences = $request->input('categories', []);

            $user->preferences()->sync($newPreferences);

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật sở thích thành công!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!',
            ]);
        }
    }
    public function ShowSettings(Request $request, $id = null)
    {
        $tab = $request->route('tab');
        $categories = Category::all();
        return view('User.Settings.Settings', ['tab' => $tab]);
    }
}
