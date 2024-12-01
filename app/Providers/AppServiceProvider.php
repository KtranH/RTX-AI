<?php

namespace App\Providers;

use App\Models\PostReview;
use App\QueryDatabase;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    use QueryDatabase;
    public function boot(): void
    {
        view()->composer('Admin.Manage.Image', function ($view) {
            $photo = PostReview::where('status', 1)->count();
            return $view->with('countReview', $photo);
        });
        view()->composer('Admin.Sidebar', function ($view) {
            $photo = PostReview::where('status', 1)->count();
            return $view->with('countReview', $photo);
        });
    }
}
