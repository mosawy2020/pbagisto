<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class packageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('\Webkul\RestApi\Http\Controllers\V1\Admin\User', '\App\Http\Controllers\AuthController');
    }
}
