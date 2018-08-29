<?php

namespace App\Repositories\Interfaces;

interface EstimateRepositoryInterface
{
    public function paginateByCondition(array $condition, $sort, $order, $limit);

    public function find($id);

    public function create(array $properties);

    public function update($id, array $properties);

    public function delete($id);
}
