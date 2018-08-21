<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\User\History;

class HistoryObserver
{

    public function created(Model $model)
    {
        if (!Auth::check()) return;

        $user = Auth::user();
        $organization = $user->selectedOrganization();
        History::create([
            'organization_id'   => $organization->id,
            'user_id'           => $user->id,
            'target'            => str_singular($model->getTable()),
            'target_id'         => $model->id,
            'action'            => 'created',
            'data'              => json_encode($model->getDirty()),
        ]);
    }

    public function updated(Model $model)
    {
        if (!Auth::check()) return;

        $user = Auth::user();
        $organization = $user->selectedOrganization();
        History::create([
            'organization_id'   => $organization->id,
            'user_id'           => $user->id,
            'target'            => str_singular($model->getTable()),
            'target_id'         => $model->id,
            'action'            => 'updated',
            'data'              => json_encode($model->getDirty()),
        ]);
    }

    public function deleted(Model $model)
    {
        if (!Auth::check()) return;

        $user = Auth::user();
        $organization = $user->selectedOrganization();
        History::create([
            'organization_id'   => $organization->id,
            'user_id'           => $user->id,
            'target'            => str_singular($model->getTable()),
            'target_id'         => $model->id,
            'action'            => 'deleted',
            'data'              => json_encode($model->getDirty()),
        ]);
    }
}
