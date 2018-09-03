<?php
declare(strict_types=1);

namespace App\Repositories\Member\Invitation;

use App\Models\Member\Invitation\Link;
use App\Repositories\Interfaces\Member\Invitation\LinkRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class LinkRepository extends AbstractRepository implements LinkRepositoryInterface
{
    public function findByToken(string $token)
    {
        $link = $this->entity->where('token', $token)
            ->where(function($query){
                $query->where('expired_at', '>=', Carbon::now())->orWhereNull('expired_at');
            })
            ->first();
        if (!$link) {
            throw new ModelNotFoundException();
        }

        return $link;
    }


    public function entity()
    {
        return Link::class;
    }
}
