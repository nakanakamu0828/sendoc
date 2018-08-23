<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Traits\Models\AuthorObservable;
use App\Traits\Models\HistoryObservable;

class Estimate extends Model
{
    use SoftDeletes;
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
        'title',
        'estimate_no',
        'client_id',
        'recipient',
        'recipient_title',
        'recipient_contact',
        'source_id',
        'sender',
        'sender_contact',
        'sender_email',
        'sender_postal_code',
        'sender_address1',
        'sender_address2',
        'sender_address3',
        'date',
        'due',
        'in_tax',
        'tax_rate',
        'remarks',
        'subtotal',
        'tax',
        'total',
        'created_by',
        'updated_by',
        'deleted_by',
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

    // Relation
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client');
    }

    public function source()
    {
        return $this->belongsTo('App\Models\Source');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function deleted_by()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Estimate\Item');
    }

    // Scope
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

    // Function
    public function generateEstimateNo()
    {
        $i = 1;
        while(is_null($this->estimate_no)) {
            $estimate_no = sprintf('%s-%03d', date('Ymd'), $i++);
            if (0 === $this->where('organization_id', $this->organization->id)->where('estimate_no', $estimate_no)->count()) {
                $this->estimate_no = $estimate_no;
            }
        }
    }
}
