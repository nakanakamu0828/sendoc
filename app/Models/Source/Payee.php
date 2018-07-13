<?php

namespace App\Models\Source;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    /**
     * テーブル
     *
     * @var string
     */
    protected $table = 'source_payees';

    protected $fillable = [
        'source_id',
        'detail',
    ];

    public function source()
    {
        return $this->belongsTo('App\Models\Source');
    }
}