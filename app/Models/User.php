<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Models\AuthorObservable;
use Illuminate\Encryption\Encrypter;

class User extends Authenticatable
{
    use Notifiable;
    use AuthorObservable;

    /**
    　* The storage format of the model's date columns.
    　*
    　* @var string
    　*/
    protected $dateFormat = 'U';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'email_token',
        'last_login_at',
        'created_ip',
        'updated_ip',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'last_login_at',
    ];

    // Relation
    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document', 'created_user_id', 'id');
    }


    public function selectedOrganization()
    {
        return $this->selectedMember()->organization;
    }

    public function selectedMember()
    {
        return $this->members()->where('selected', 1)->first();
    }

    public static function generateEmailToken()
    {
        $token = null;
        while(is_null($token)) {
            $token = str_replace(['+', '/'], ['-', '_'], base64_encode(Encrypter::generateKey(app()['config']['cipher'])));
            if (User::where('email_token', $token)->first()) $token = null;
        }

        return $token;
    }
}
