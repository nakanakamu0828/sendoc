<?php

namespace App\Repositories\Interfaces\Member\Invitation;

interface LinkRepositoryInterface
{
    public function findByToken(string $token);
}
