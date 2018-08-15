<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\AuthorObservable;
use App\Traits\Models\HistoryObservable;

class Member extends Model
{
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
        'user_id',
        'role',
        'selected',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }

    public function scopeSearchByCondition($query, $condition)
    {
        return $query
        ;
    }

    /**
     * 管理者権限かどうかの判定
     */
    public function isAdmin()
    {
        return 'admin' === $this->role;
    }
}
