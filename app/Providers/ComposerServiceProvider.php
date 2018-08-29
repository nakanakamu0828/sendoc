<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\SexComposer;
use App\Http\ViewComposers\OrganizationTypeComposer;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composers([
            SexComposer::class => [
                'setting.profile.edit'
            ],
            OrganizationTypeComposer::class => [
                'auth.register'
            ]
        ]);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
