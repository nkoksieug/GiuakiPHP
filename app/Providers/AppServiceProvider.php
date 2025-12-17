<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <-- Thêm dòng này ở trên cùng

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
        // Kiểm tra nếu đang chạy trên môi trường Production (Render) thì ép dùng HTTPS
        if($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
