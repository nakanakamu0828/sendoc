<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
}
