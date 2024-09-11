<?php

namespace App;

use App\Models\Category;
use App\Models\HistoryImageAI;
use App\Models\User;
use Illuminate\Support\Facades\DB;

trait FindInformation
{
    //
    private function find_id()
    {
        $email = request()->cookie("token_account");
        $id = User::where("email",$email)->first();
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
}
