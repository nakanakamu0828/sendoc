<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
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
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
