<?php
declare(strict_types=1);

namespace App\Repositories;

use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;
use App\Models\Organization;
use App\Models\User;
use Auth;
use DB;
use Schema;

abstract class AppRepository extends AbstractRepository
{

    protected $organization;
    protected $user;

    public function setUser(User $user)
    {
        $this->user = $user;
        $this->organization = $this->user->selectedOrganization();

        return $this;
    }

    public function paginateByCondition(array $condition, $sort, $order, $limit)
    {
        $query = $this->entity->where(function($query) {
                if ($this->organization && $this->hasOrganizationId()) {
                    $query->where('organization_id', $this->organization->id);
                }
            })
            ->searchByCondition($condition)
            ->orderBy($sort, $order)
            ->paginate($limit)
        ;
        return $query;
    }

    public function pluckByCondition($column, array $condition)
    {
        return $query = $this->entity->where(function($query) {
                if ($this->organization && $this->hasOrganizationId()) {
                    $query->where('organization_id', $this->organization->id);
                }
            })
            ->searchByCondition($condition)
            ->pluck($column)
        ;
    }


    public function find($id)
    {
        $model = $this->entity
            ->where(function($query) {
                if ($this->organization && $this->hasOrganizationId()) {
                    $query->where('organization_id', $this->organization->id);
                }
            })
            ->find($id);

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

    /**
     * 登録処理
     */
    public function create(array $properties)
    {

        if ($this->organization && $this->hasOrganizationId()) {
            $properties['organization_id'] = $this->organization->id;
        }
        return $this->entity->create($properties);
    }

    /**
     * 更新処理
     */
    public function update($id, array $properties)
    {
        return $this->entity->where(function($query) {
            if ($this->organization && $this->hasOrganizationId()) {
                $query->where('organization_id', $this->organization->id);
            }
        })->find($id)->update($properties);
    }

    /**
     * 削除処理
     */
    public function delete($id)
    {
        return $this->entity->where(function($query) {
            if ($this->organization && $this->hasOrganizationId()) {
                $query->where('organization_id', $this->organization->id);
            }
        })->find($id)->delete();
    }

    protected function hasOrganizationId()
    {
        return Schema::hasColumn($this->entity->getTable(), 'organization_id');
    }
    
}
