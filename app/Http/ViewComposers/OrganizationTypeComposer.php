<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use App\Enums\Organization\Type;

class OrganizationTypeComposer {

    /**
     * @var String
     */
    protected $organization_types;

    public function __construct()
    {
        $this->organization_types = Type::toArray();
    }

    /**
     * Bind data to the view.
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('organization_types', $this->organization_types);
    }
}