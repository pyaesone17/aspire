<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repository\{EloquentLoanRepository, EloquentUserRepository};
use App\Repository\Contracts\{LoanRepositoryContract, UserRepositoryContract};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(LoanRepositoryContract::class, EloquentLoanRepository::class);
        $this->app->bind(UserRepositoryContract::class, EloquentUserRepository::class);
    }
}
