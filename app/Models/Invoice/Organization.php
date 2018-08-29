<?php

namespace App\Models\Invoice;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
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
    protected $table = 'invoice_organizations';

    protected $fillable = [
        'invoice_id',
        'organization_id',
        'role',
    ];


    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
