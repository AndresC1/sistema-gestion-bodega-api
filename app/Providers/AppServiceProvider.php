<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\EntryProductRepository;
use App\Repository\DetailsPurchaseRepository;
use App\Repository\InventoryRepository;
use App\Repository\PurchaseRepository;
use App\Repository\DetailsEntryProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DetailsPurchaseRepository::class, function ($app) {
            return new DetailsPurchaseRepository();
        });
        $this->app->bind(EntryProductRepository::class, function ($app) {
            return new EntryProductRepository();
        });
        $this->app->bind(InventoryRepository::class, function ($app) {
            return new InventoryRepository();
        });
        $this->app->bind(PurchaseRepository::class, function ($app) {
            return new PurchaseRepository();
        });
        $this->app->bind(DetailsEntryProductRepository::class, function ($app) {
            return new DetailsEntryProductRepository();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
