<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Invoice\Item;
use App\Models\Invoice\Payee;
use App\Models\Invoice\Organization;
use App\Repositories\Interfaces\InvoiceRepositoryInterface;

class InvoiceRepository extends AppRepository implements InvoiceRepositoryInterface
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
            ->invoice_organizations()
            ->saveMany([
                new Organization([
                    'organization_id' => $this->organization->id,
                    'role' => isset($properties['invoice_role']) ? $properties['invoice_role'] : 'sender'
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

        if (isset($properties['payees']) && is_array($properties['payees'])) {
            $model
                ->payees()
                ->saveMany(array_map(function($p){
                    return new Payee($p);
                }, array_filter($properties['payees'], function($p) {
                    return $p['detail'];
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
                $item = isset($i['id']) ? $entity->items()->find($i['id']) : new Item(['invoice_id' => $entity->id]);
                if ((empty($i['name']) && empty($i['price']) && empty($i['quantity'])) || $i['_delete']) {
                    $item->delete();
                } else {
                    $item->fill($i)->save();
                }
            }
        }

        if (isset($properties['payees']) && is_array($properties['payees'])) {
            foreach ($properties['payees'] as $p) {
                $payee = isset($p['id']) ? $entity->payees()->find($p['id']) : new Payee(['invoice_id' => $entity->id]);
                if (empty($p['detail'])) {
                    $payee->delete();
                } else {
                    $payee->fill($p)->save();
                }
            }
        }

        return $entity;
    }


    public function entity()
    {
        return Invoice::class;
    }
}
