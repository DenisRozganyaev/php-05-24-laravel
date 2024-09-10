<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Policies\Api\ProductPolicy;
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
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        if(env('APP_ENV') === 'production')
        {
            URL::forceScheme('https');
        }

        Paginator::useBootstrapFive();
        Gate::policy(Product::class, ProductPolicy::class);
        //        Gate::policy(Order::class, OrderPolicy::class);
    }
}
