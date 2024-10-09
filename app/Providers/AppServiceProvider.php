<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\ErrorReport;

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
    public function boot(): void
    {
        Paginator::useBootstrapFive();

        View::composer('*', function ($view) {
            if (Auth::check() && Auth::user()->role == 3) { // Ensure the user is logged in and is a student
                $pendingCount = ErrorReport::where('user_id', Auth::id())
                                           ->where('status', 'pending')
                                           ->count();
                $view->with('pendingCount', $pendingCount);
            }
        });
    }
}
