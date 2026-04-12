<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Data\Foo;
use App\Data\Bar;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;

class FooBarServiceProvider extends ServiceProvider
{
    public array $singletons = [
        HelloService::class => HelloServiceIndonesia::class
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app){
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function provides() : array
    {
        return [HelloService::class, Foo::class, Bar::class];
    }
}
