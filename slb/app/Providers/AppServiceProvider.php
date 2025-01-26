<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrap();

        // Customize pagination views
        view()->composer('vendor.pagination.default', function ($view) {
            $view->with('prevButtonText', '&laquo; Previous');
            $view->with('nextButtonText', 'Next &raquo;');
        });

        // Customize pagination links
        view()->composer('vendor.pagination.default', function ($view) {
            $view->with('wrapperTag', 'div');
            $view->with('itemClass', 'page-item');
            $view->with('activeClass', 'active');
            $view->with('prevClass', 'page-item');
            $view->with('nextClass', 'page-item');
        });

    }
}
