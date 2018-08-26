<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
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
    protected $table = 'user_profiles';

    protected $fillable = [
        'user_id',
        'name',
        'birthday',
        'sex',
        'tel',
        'url',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }


    public function getSexDescription()
    {
        return \App\Enums\User\Profile\Sex::getDescription($this->sex);
    }
}
