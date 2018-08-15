<?php

namespace App\Traits\Models;

use App\Observers\AuthorObserver;

trait AuthorObservable
{
    public static function bootAuthorObservable()
    {
        static::observe(AuthorObserver::class);
    }
}