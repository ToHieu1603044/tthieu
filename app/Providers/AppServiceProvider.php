<?php

namespace App\Providers;

use App\Models\Category;
use DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;
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
    public function boot(): void
    {
        Paginator::useBootstrapFive();
    
        view()->composer('*', function ($view) {
            $categories = Category::whereNull('parent_id')
                ->with('children')
                ->get();
    
            $view->with(['categories' => $categories]);
        });
    }
    
}
