<?php

namespace App\Providers;

use App\Http\ViewComposers\NavbarComposer;
use App\View\Components\Footer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        View::composer('*', NavbarComposer::class);
        Blade::component('footer', Footer::class);
    }
}
