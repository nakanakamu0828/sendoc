<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Kurt\Repoist\RepoistServiceProvider');
        }

        // Repogitoryクラス
        $this->app->bind(
            \App\Repositories\Interfaces\ClientRepositoryInterface::class,
            \App\Repositories\ClientRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\SourceRepositoryInterface::class,
            \App\Repositories\SourceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\MemberRepositoryInterface::class,
            \App\Repositories\MemberRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\InvoiceRepositoryInterface::class,
            \App\Repositories\InvoiceRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\EstimateRepositoryInterface::class,
            \App\Repositories\EstimateRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\Member\Invitation\LinkRepositoryInterface::class,
            \App\Repositories\Member\Invitation\LinkRepository::class
        );
    }
}
