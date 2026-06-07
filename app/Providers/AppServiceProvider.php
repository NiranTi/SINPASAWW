<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

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
        //
        Carbon::setLocale('id');
        
        // Create Services/Denah directory structure
        $this->createServicesDenahDirectory();
    }
    
    /**
     * Create the app/Services/Denah directory structure
     */
    private function createServicesDenahDirectory(): void
    {
        $denahPath = app_path('Services/Denah');
        if (!is_dir($denahPath)) {
            @mkdir($denahPath, 0755, true);
        }
    }
}
