<?php

namespace Webkul\AbandonCart\Providers;

use Illuminate\Support\Facades\Event;
use Webkul\AbandonCart\Console\Commands\AbandonCartMail;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;
use Webkul\AbandonCart\Http\Middleware\AbandonCart;

class AbandonCartServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadRoutesFrom(__DIR__ . '/../Http/routes.php');

        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'abandoncart');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'abandoncart');

        Event::listen('checkout.cart.add.after', 'Webkul\AbandonCart\Listeners\Cart@addAfter');

        Event::listen('checkout.order.save.after', 'Webkul\AbandonCart\Listeners\Order@placeAfter');

        $router->aliasMiddleware('abandoncart', AbandonCart::class);

        //Admin view files
        $this->publishes([
            __DIR__ . '/../Resources/views/admin/layouts/nav-aside.blade.php' => resource_path('views/vendor/admin/layouts/nav-aside.blade.php'),
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();

        $this->registerCommands();
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/menu.php', 'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/system.php', 'core'
        );
    }

      /**
     * Register the console commands of this package
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AbandonCartMail::class,
            ]);
        }
    }
}
