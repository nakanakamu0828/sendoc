<?php

namespace App\Repositories;

use App\Models\Source;
use App\Repositories\Interfaces\SourceRepositoryInterface;

class SourceRepository extends AppRepository implements SourceRepositoryInterface
{
    public function entity()
    {
        return Source::class;
    }
}
