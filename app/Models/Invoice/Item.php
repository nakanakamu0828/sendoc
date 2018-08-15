<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\AuthorObservable;

class Item extends Model
{
    use AuthorObservable;

    /**
    　* The storage format of the model's date columns.
    　*
    　* @var string
    　*/
    protected $dateFormat = 'U';

    /**
     * テーブル
     *
     * @var string
     */
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'name',
        'price',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
