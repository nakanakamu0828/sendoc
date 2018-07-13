<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    /**
     * テーブル
     *
     * @var string
     */
    protected $table = 'invoice_payees';

    protected $fillable = [
        'invoice_id',
        'detail',
    ];

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }
}
