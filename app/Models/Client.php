<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'contact_name',
        'email',
        'postal_code',
        'prefecture_id',
        'address1',
        'address2',
        'remarks',
    ];

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function prefecture()
    {
        return $this->belongsTo('App\Models\Prefecture');
    }


    public function scopeSearchByCondition($query, $condition)
    {
        return $query
            ->whereLikeBothName(isset($condition['name']) ? $condition['name'] : null)
            ->whereLikeBothEmail(isset($condition['email']) ? $condition['email'] : null)
            ->whereLikeBothContactName(isset($condition['contact_name']) ? $condition['contact_name'] : null)
        ;
    }

    public function scopeWhereLikeBothName($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->where('name', 'like', '%' . $value . '%');
        }
    }

    public function scopeWhereLikeBothEmail($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->where('email', 'like', '%' . $value . '%');
        }
    }

    public function scopeWhereLikeBothContactName($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->where('contact_name', 'like', '%' . $value . '%');
        }
    }
}
