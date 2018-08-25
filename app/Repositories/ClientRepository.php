<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Client;
use App\Repositories\Interfaces\ClientRepositoryInterface;

class ClientRepository extends AppRepository implements ClientRepositoryInterface
{
    public function entity()
    {
        return Client::class;
    }
}
