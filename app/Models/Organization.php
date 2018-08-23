<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
    　* The storage format of the model's date columns.
    　*
    　* @var string
    　*/
    protected $dateFormat = 'U';

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

    public function estimates()
    {
        return $this->hasMany('App\Models\Estimate');
    }

    public function member_invitation_links()
    {
        return $this->hasMany('App\Models\Member\Invitation\Link');
    }
}
