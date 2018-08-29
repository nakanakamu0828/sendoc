<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Traits\Models\AuthorObservable;
use App\Traits\Models\HistoryObservable;
use App\Models\Invoice\Organization;
use DB;

class Invoice extends Model
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
        'title',
        'invoice_no',
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

    public function invoice_organizations()
    {
        return $this->hasMany('App\Models\Invoice\Organization');
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Models\Organization', 'invoice_organizations', 'invoice_id', 'organization_id');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Invoice\Item');
    }

    public function payees()
    {
        return $this->hasMany('App\Models\Invoice\Payee');
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

    public function scopeWhereOrganizationId($query, $id)
    {
        if (empty($id)) return $query;
        return $query->whereIn('id', Organization::where('organization_id', $id)->pluck('invoice_id'));
    }

    // Function
    public function generateInvoiceNo($organizationId)
    {
        $i = 1;
        $this->invoice_no = null;
        while(is_null($this->invoice_no)) {
            $invoice_no = sprintf('%s-%03d', date('Ymd'), $i++);
            $count = $this->join('invoice_organizations', 'invoice_organizations.invoice_id', 'invoices.id')
                ->where('invoice_organizations.organization_id', $organizationId)
                ->where('invoice_no', $invoice_no)
                ->count();

            if (0 === $count) {
                $this->invoice_no = $invoice_no;
            }
        }
    }

}
