<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\AuthorObservable;
use App\Traits\Models\HistoryObservable;

class Source extends Model
{

    use AuthorObservable;
    use HistoryObservable;

    /**
    　* The storage format of the model's date columns.
    　*
    　* @var string
    　*/
    protected $dateFormat = 'U';

    protected $fillable = [
        'organization_id',
        'name',
        'contact_name',
        'email',
        'postal_code',
        'address1',
        'address2',
        'address3',
        'created_by',
        'updated_by',
    ];

    // Relation
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function payees()
    {
        return $this->hasMany('App\Models\Source\Payee');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    // Scope
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

    // Function
    public function printPostalCode()
    {
        if ($this->postal_code) {
            return '〒' . $this->postal_code;
        } else {
            return '';
        }
    }
    public function printFullAddress($delimiter = ' ')
    {
        $address = array_filter([$this->printPostalCode(), $this->address1, $this->address2, $this->address3]);
        return empty($address) ? '' : join($delimiter, $address);
    }
}
