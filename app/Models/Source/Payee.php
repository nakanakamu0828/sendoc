<?php

namespace App\Models\Source;

use Illuminate\Database\Eloquent\Model;

class Payee extends Model
{
    protected $fillable = [
        'source_id',
        'detail',
    ];

    public function source()
    {
        return $this->belongsTo('App\Models\Source');
    }
}
