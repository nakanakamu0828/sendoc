<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Schema;
use Request;

class AuthorObserver
{
    public function creating(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'created_by')) {
            $model->created_by = Auth::user()->id;
        }
        if (Schema::hasColumn($model->getTable(), 'created_ip')) {
            $model->created_ip = Request::ip();
        }
    }
    public function updating(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'updated_by') && $model->isDirty()) {
            $model->updated_by = Auth::user()->id;
        }
        if (Schema::hasColumn($model->getTable(), 'updated_ip')) {
            $model->updated_ip = Request::ip();
        }
    }
    public function saving(Model $model)
    {
        $this->updating($model);
    }

    public function deleting(Model $model)
    {
        if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
            $model->deleted_by = Auth::user()->id;
        }
        if (Schema::hasColumn($model->getTable(), 'deleted_ip')) {
            $model->deleted_ip = Request::ip();
        }
    }
}
