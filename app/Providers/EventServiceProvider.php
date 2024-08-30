<?php

namespace App\Providers;

use App\Events\OrderCreatedEvent;
use App\Listeners\Orders\CreatedListener;
use App\Listeners\RestoreCartOnLogin;
use App\Listeners\SaveCartOnLogout;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected static $shouldDiscoverEvents = false;

    protected $listen = [
        OrderCreatedEvent::class => [
            CreatedListener::class,
        ],
        Login::class => [
            RestoreCartOnLogin::class,
        ],
        Logout::class => [
            SaveCartOnLogout::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
