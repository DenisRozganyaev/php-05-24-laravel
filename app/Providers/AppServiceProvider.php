<?php

namespace App\Providers;

use App\Repositories\Contract\ImagesRepositoryContract;
use App\Repositories\Contract\ProductsRepositoryContract;
use App\Repositories\ImagesRepository;
use App\Repositories\ProductsRepository;
use App\Services\Contracts\FileServiceContract;
use App\Services\FileService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public array $bindings = [
        ProductsRepositoryContract::class => ProductsRepository::class,
        ImagesRepositoryContract::class => ImagesRepository::class,
        FileServiceContract::class => FileService::class
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
    }
}
