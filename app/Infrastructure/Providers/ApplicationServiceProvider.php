<?php

namespace App\Infrastructure\Providers;

use App\Domain\Repositories\CustomerRepository;
use App\Domain\Repositories\OrderProductRepository;
use App\Domain\Repositories\OrderRepository;
use App\Domain\Repositories\OrderStatusRepository;
use App\Domain\Services\CustomerDataProvider;
use App\Infrastructure\Http\API\ApiConnector;
use App\Infrastructure\Http\API\DummyJsonConnector;
use App\Infrastructure\Repositories\EloquentCustomerRepository;
use App\Infrastructure\Repositories\EloquentOrderProductRepository;
use App\Infrastructure\Repositories\EloquentOrderRepository;
use App\Infrastructure\Repositories\EloquentOrderStatusRepository;
use App\Infrastructure\Services\DummyJsonService;
use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CustomerRepository::class, EloquentCustomerRepository::class);
        $this->app->bind(ApiConnector::class, DummyJsonConnector::class);
        $this->app->bind(CustomerDataProvider::class, DummyJsonService::class);
        $this->app->bind(OrderRepository::class, EloquentOrderRepository::class);
        $this->app->bind(OrderStatusRepository::class, EloquentOrderStatusRepository::class);
        $this->app->bind(OrderProductRepository::class, EloquentOrderProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }
}
