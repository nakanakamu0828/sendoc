<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    protected $fillable = [
        'name',
    ];

    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function sources()
    {
        return $this->hasMany('App\Models\Source');
    }

    public function invoices()
    {
        return $this->hasMany('App\Models\Invoice');
    }

    public function member_invitation_links()
    {
        return $this->hasMany('App\Models\Member\Invitation\Link');
    }
}
