<?php

namespace App\Http\Controllers\Admin\Essential;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use App\Models\WorkFlow;
use Illuminate\Http\Request;

class HomeAdmin extends Controller
{
    //
    public function ShowHome()
    {
        $year = now()->year;

        $countAlbum = Album::all()->count();
        $countImage = Photo::all()->count();
        $countWorkFlow = WorkFlow::all()->count();
        $countUser = User::all()->count();
        $countAlbumPrivate = Album::where('is_private', 1)->count();
        $countAlbumPublic = Album::where('is_private', 0)->count();

        $photosPerMonth = Photo::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $formattedPhotosPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedPhotosPerMonth[] = $photosPerMonth[$i] ?? 0; 
        }

        $userPerMonth = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $formattedUserPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedUserPerMonth[] = $userPerMonth[$i] ?? 0; 
        }

        return view('Admin.Essential.Home', compact('formattedPhotosPerMonth', 'formattedUserPerMonth', 'countAlbum', 'countImage', 'countWorkFlow', 'countUser', 'countAlbumPrivate', 'countAlbumPublic'));
    }
}
