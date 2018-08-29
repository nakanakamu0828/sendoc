<?php

namespace App\Models\Estimate;

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
    protected $table = 'estimate_organizations';

    protected $fillable = [
        'estimate_id',
        'organization_id',
        'role',
    ];

    public function estimate()
    {
        return $this->belongsTo('App\Models\Estimate');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
