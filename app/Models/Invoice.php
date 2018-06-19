<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Invoice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'organization_id',
        'title',
        'client_id',
        'date',
        'due',
        'in_tax',
        'tax_rate',
        'remarks',
        'subtotal',
        'tax',
        'total',
    ];

    protected $dates = [
        'date',
        'due',
        'deleted_at',
    ];


    public function __construct(array $attributes = [])
    {
        $attributes = array_merge([
            'in_tax' => true,
            'tax_rate' => 8,
            'date' => Carbon::now(),
        ], $attributes);

        $this->fill($attributes);
        parent::__construct($attributes);
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Invoice\Item');
    }

    public function scopeSearchByCondition($query, $condition)
    {
        return $query
            ->whereLikeBothTitle(isset($condition['title']) ? $condition['title'] : null)
        ;
    }

    public function scopeWhereLikeBothTitle($query, $value)
    {
        if (empty($value)) {
            return $query;
        } else {
            return $query->where('title', 'like', '%' . $value . '%');
        }
    }
}
