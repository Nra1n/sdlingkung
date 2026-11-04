<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
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
    public function boot(): void
    {
        // Gunakan tampilan pagination Bootstrap 5 agar serasi dengan layout.
        Paginator::useBootstrapFive();

        // Data pengaturan sekolah tersedia otomatis di semua view (navbar, footer, dll).
        View::composer('*', function ($view) {
            $view->with('site', SiteSetting::current());
        });
    }
}
