<?php

namespace App\Traits\Models;

use App\Observers\HistoryObserver;

trait HistoryObservable
{
    public static function bootHistoryObservable()
    {
        static::observe(HistoryObserver::class);
    }
}