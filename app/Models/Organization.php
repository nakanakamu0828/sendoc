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
        'type',
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

    public function member_invitation_links()
    {
        return $this->hasMany('App\Models\Member\Invitation\Link');
    }

    public function invoice_organizations()
    {
        return $this->hasMany('App\Models\Invoice\Organization', 'organization_id', 'id');
    }

    public function estimate_organizations()
    {
        return $this->hasMany('App\Models\Estimate\Organization', 'organization_id', 'id');
    }

    public function invoices()
    {
        return $this->belongsToMany('App\Models\Invoice', 'invoice_organizations', 'organization_id', 'invoice_id');
    }

    public function estimates()
    {
        return $this->belongsToMany('App\Models\Estimate', 'estimate_organizations', 'organization_id', 'estimate_id');
    }
}
