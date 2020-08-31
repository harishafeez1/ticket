<?php

namespace Coldxpress\Ticket;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class TicketServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     * 
     * @var string
     */
    protected $namespace = 'Coldxpress\Ticket\Http\Controllers';

    public function boot()
    {
        //dd(asset('ticket/assets/plugins/global/plugins.bundle.css'));
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        // $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'ticket');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->mapApiRoutes();

        //      $this->publishes([__DIR__.'/resources/ticket' => public_path()],
        //        'views');

    }

    public function register()
    {
    }


    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/routes/api.php');
    }
}
