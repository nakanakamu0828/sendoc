<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{

    protected $fillable = [
        'organization_id',
        'user_id',
        'role',
        'selected'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    /**
     * 管理者権限かどうかの判定
     */
    public function isAdmin()
    {
        return 'admin' === $this->role;
    }
}
