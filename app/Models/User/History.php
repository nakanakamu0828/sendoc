<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class History extends Model
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
    protected $table = 'user_histories';

    protected $fillable = [
        'organization_id',
        'user_id',
        'target',
        'target_id',
        'action',
        'data',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
