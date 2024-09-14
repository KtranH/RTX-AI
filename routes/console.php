<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\FindInformation;
use App\Models\HistoryImageAI;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('images:delete-old', function () 
{
    $users = User::all();
    foreach ($users as $user) {
        HistoryImageAI::where('user_id', $user->id)->where('created_at', '<', now()->subDays(10))->delete();
    }
})->daily();

Artisan::command('addMoreTimes', function ()
{
    $users = User::all();
    foreach ($users as $user) 
    {
        $user->times = $user->times + 10;
        $user->save();
    }
})->daily();