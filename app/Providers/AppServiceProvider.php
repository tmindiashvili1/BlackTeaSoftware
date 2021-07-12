<?php

namespace App\Providers;

use App\Repository\Contracts\ClientRepositoryInterface;
use App\Repository\Contracts\ComplaintRepositoryInterface;
use App\Repository\Eloquent\ClientRepository;
use App\Repository\Eloquent\ComplaintRepository;
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
        $this->app->bind(ClientRepositoryInterface::class, ClientRepository::class);
        $this->app->bind(ComplaintRepositoryInterface::class, ComplaintRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
