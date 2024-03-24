<?php

namespace App\Providers;

use App\Models\User;
use App\Models\BankLog;
use App\Models\ProductLog;
use App\Observers\UserObserver;
use App\Observers\BankLogObserver;
use App\Observers\ProductLogObserver;
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
        User::observe(UserObserver::class);
        BankLog::observe(BankLogObserver::class);
        ProductLog::observe(ProductLogObserver::class);
    }
}
