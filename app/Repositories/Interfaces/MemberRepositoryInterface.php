<?php

namespace App\Repositories\Interfaces;

interface MemberRepositoryInterface
{
    public function paginateByCondition(array $condition, $sort, $order, $limit);

    public function create(array $properties);

    public function delete($id);
}
