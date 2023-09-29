<?php

namespace App\Providers;

use App\Models\Setting;
use App\Models\Shortcut;
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
        $settings = Setting::getSetting();
        $shortcuts = Shortcut::active()->get();
        view()->share('settings', $settings);
        view()->share('shortcuts', $shortcuts);
        view()->share('dark_mode', !empty($settings['dark_mode']));
    }
}
