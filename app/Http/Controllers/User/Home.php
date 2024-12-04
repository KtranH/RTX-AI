<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Notification;
use Illuminate\Http\Request;

class Home extends Controller
{
    // Show the home page
    public function ShowHome()
    {
        $landscape = Category::where("name", "like", "%" . "Phong cảnh" . "%")->firstOrFail();
        $animal = Category::where("name", "=", "Động vật")->firstOrFail();
        $fashion = Category::where("name", "like", "%" . "Thời trang" . "%")->firstOrFail();
        $city = Category::where("name", "like", "%" . "Thành phố" . "%")->firstOrFail();
        $travel = Category::where("name", "like", "%" . "Du lịch" . "%")->firstOrFail();
        $tech = Category::where("name", "like", "%" . "Công nghệ" . "%")->firstOrFail();
        return view("User.Home.Home", compact("landscape", "animal", "fashion", "city", "travel", "tech"));
    }

    public function ApiNotification($userId)
    {
        $notifications = Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->simplePaginate(3);

        $notifications->transform(function ($notification) {
            $notification->data = json_decode($notification->data);
            return $notification;
        });
        return response()->json($notifications);
    }

    public function ApiReadNotification($notificationId)
    {
        $notification = Notification::find($notificationId);
        $notification->update(['is_read' => 1]);
        $notification->save();
        return response()->json($notification);
    }
}
