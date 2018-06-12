<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'organization_id',
        'name',
        'country',
        'contact_name',
        'email',
        'user_id',
        'client_type',
        'remarks',
        'email_status',
        'email_error'
    ];

    public static $COUNTRIES = [
        'japan',
        'china',
        'koria',
    ];

    public static $TYPES = [
        'all',
        'proposal_only',
        'personnel_only',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }


    public function scopeSearchByCondition($query, $condition)
    {
        return $query
            ->whereLikeBothName(isset($condition['name']) ? $condition['name'] : null)
            ->whereLikeBothEmail(isset($condition['email']) ? $condition['email'] : null)
            ->whereLikeBothContactName(isset($condition['contact_name']) ? $condition['contact_name'] : null)
            ->whereInCountry(isset($condition['country']) ? $condition['country'] : [])
            ->whereInClientType(isset($condition['client_type']) ? $condition['client_type'] : [])
            ->whereInUserId(isset($condition['user_id']) ? $condition['user_id'] : [])
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

    public function scopeWhereInCountry($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->whereIn('country', $value);
        }
        
    }

    public function scopeWhereInClientType($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->whereIn('client_type', $value);
        }
    }

    public function scopeWhereInUserId($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->whereIn('user_id', $value);
        }
    }
}
