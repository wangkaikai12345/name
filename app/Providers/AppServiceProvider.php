<?php

namespace App\Providers;

use App\Domain;
use App\Observers\DomainObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 为 User 模型注册观察者
        Domain::observe(DomainObserver::class);
    }
}
