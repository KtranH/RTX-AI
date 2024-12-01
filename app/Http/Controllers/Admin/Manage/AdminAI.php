<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\HistoryImageAI;
use Illuminate\Http\Request;

class AdminAI extends Controller
{
    //
    public function ShowAI(){
        $year = now()->year;

        $photosPerMonth = HistoryImageAI::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
        ->whereYear('created_at', $year)
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('count', 'month')
        ->toArray();

        $formattedPhotosPerMonth = [];
        for ($i = 1; $i <= 12; $i++) {
            $formattedPhotosPerMonth[] = $photosPerMonth[$i] ?? 0; 
        }
        return view('Admin.Manage.AI', compact('formattedPhotosPerMonth'));
    }
    public function ImageAI(Request $request){
        $imagesPerPage = 4;
        $page = $request->get('page', 1);
        $photos = HistoryImageAI::paginate($imagesPerPage, ['*'], 'page', $page);

        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
}
