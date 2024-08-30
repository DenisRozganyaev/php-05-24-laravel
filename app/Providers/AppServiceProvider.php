<?php

namespace App\Providers;

use App\Listeners\RestoreCartOnLogin;
use App\Listeners\SaveCartOnLogout;
use App\Models\Order;
use App\Policies\OrderPolicy;
use App\Repositories\Contract\ImagesRepositoryContract;
use App\Repositories\Contract\OrderRepositoryContract;
use App\Repositories\Contract\ProductsRepositoryContract;
use App\Repositories\ImagesRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductsRepository;
use App\Services\Contracts\FileServiceContract;
use App\Services\Contracts\InvoiceServiceContract;
use App\Services\Contracts\PaypalServiceContract;
use App\Services\FileService;
use App\Services\InvoiceService;
use App\Services\PaypalService;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        ProductsRepositoryContract::class => ProductsRepository::class,
        ImagesRepositoryContract::class => ImagesRepository::class,
        FileServiceContract::class => FileService::class,
        PaypalServiceContract::class => PaypalService::class,
        OrderRepositoryContract::class => OrderRepository::class,
        InvoiceServiceContract::class => InvoiceService::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        Event::listen(
            Login::class,
            RestoreCartOnLogin::class
        );
        Event::listen(
            Logout::class,
            SaveCartOnLogout::class
        );
//        Gate::policy(Order::class, OrderPolicy::class);
    }
}
