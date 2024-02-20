<?php

namespace App\Providers;

use App\Support\Basket\Basket;
use App\Support\Cost\BasketCost;
use App\Support\Cost\Contract\CostInterface;
use App\Support\Cost\DiscountCost;
use App\Support\Cost\ShippingCost;
use App\Support\Discount\DiscountManager;
use App\Support\Storage\Contract\StorageInterface;
use App\Support\Storage\SessionStorage;
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
        $this->app->bind(StorageInterface::class, function($app){
            return new SessionStorage('card');
        });

        $this->app->bind(CostInterface::class, function($app){
            $basketCost   = new BasketCost($app->make(Basket::class));
            $shippingCost = new ShippingCost($basketCost);
            $discountCost = new DiscountCost($shippingCost, $app->make(DiscountManager::class));
            return $discountCost;
        });
    }
}
