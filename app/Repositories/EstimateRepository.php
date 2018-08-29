<?php

namespace App\Repositories;

use App\Models\Estimate;
use App\Models\Estimate\Item;
use App\Models\Estimate\Organization;
use App\Repositories\Interfaces\EstimateRepositoryInterface;


class EstimateRepository extends AppRepository implements EstimateRepositoryInterface
{

    public function paginateByCondition(array $condition, $sort, $order, $limit)
    {
        $query = $this->entity
            ->whereOrganizationId(optional($this->organization)->id)
            ->searchByCondition($condition)
            ->orderBy($sort, $order)
            ->paginate($limit)
        ;
        return $query;
    }

    public function find($id)
    {
        $model = $this->entity
            ->whereOrganizationId(optional($this->organization)->id)
            ->find($id);

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    public function create(array $properties)
    {
        $model = $this->entity->create($properties);


        $model
            ->estimate_organizations()
            ->saveMany([
                new Organization([
                    'organization_id' => $this->organization->id,
                    'role' => isset($properties['estimate_role']) ? $properties['estimate_role'] : 'sender'
                ])
            ])
        ;

        if (isset($properties['items']) && is_array($properties['items'])) {
            $model
                ->items()
                ->saveMany(array_map(function($i){
                    return new Item($i);
                }, array_filter($properties['items'], function($i) {
                    return !$i['_delete'] && $i['name'] && $i['price'] && $i['quantity'];
                })))
            ;
        }
    }

    public function update($id, array $properties)
    {
        $entity = $this->find($id);
        $entity->update($properties);

        if (isset($properties['items']) && is_array($properties['items'])) {
            foreach ($properties['items'] as $i) {
                $item = isset($i['id']) ? $entity->items()->find($i['id']) : new Item(['estimate_id' => $entity->id]);
                if ((empty($i['name']) && empty($i['price']) && empty($i['quantity'])) || $i['_delete']) {
                    $item->delete();
                } else {
                    $item->fill($i)->save();
                }
            }
        }

        return $entity;
    }

    public function entity()
    {
        return Estimate::class;
    }
}
