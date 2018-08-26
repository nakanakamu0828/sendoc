<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Enums\User\Profile\Sex;

class SexComposer {

    /**
     * @var String
     */
    protected $sexes;

    public function __construct()
    {
        $this->sexes = Sex::toArray();
    }

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('sexes', $this->sexes);
    }
}