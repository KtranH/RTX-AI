<?php

namespace App;

use App\Models\Category;
use App\Models\HistoryImageAI;
use App\Models\Like;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\ImageOptimizer\OptimizerChainFactory;

trait QueryDatabase
{
    //
    private function find_id()
    {
        $email = request()->cookie("token_account");
        $id = User::where("email",$email)->firstOrFail();
        return $id->id;
    }
    private function find_id_categorie($x)
    {
        return Category::where("name", $x)->value('id') ?? 0;
    }
    private function deleteOldImages($id)
    {
        HistoryImageAI::where('user_id', $id)->where('created_at', '<', now()->subDays(10))->delete();
    }
    private function storeImageHistory($url, $userId)
    {
        HistoryImageAI::create([
            'user_id' => $userId,
            'url' => $url,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
    private function checkLike($id, $userId)
    {
        return Like::where('photo_id', $id)->where('user_id', $userId)->first();
    }
    private function OptimizationImage($image, $pathImage)
    {
        $tempPath = $image->store('temp');
        $optimizedPath = OptimizerChainFactory::create();
        $optimizedPath->optimize(storage_path('app/' . $tempPath));

        Storage::disk('r2')->put($pathImage, file_get_contents(storage_path('app/' . $tempPath)));
        Storage::delete($tempPath);
    }
}
