<?php

namespace App\Providers;

use App\Models\Script;
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
        $scripts_head = Script::active()->where('position', 'head')->orderBy('order')->get();
        $scripts_footer = Script::active()->where('position', 'footer')->orderBy('order')->get();
        $scripts_body_top = Script::active()->where('position', 'bodyTop')->orderBy('order')->get();
        $scripts_body_bottom = Script::active()->where('position', 'bodyBottom')->orderBy('order')->get();

        view()->share('scripts_head', $scripts_head);
        view()->share('scripts_footer', $scripts_footer);
        view()->share('scripts_body_top', $scripts_body_top);
        view()->share('scripts_body_bottom', $scripts_body_bottom);
    }
}
