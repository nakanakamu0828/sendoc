<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{

    protected $fillable = [
        'name',
    ];

    public function mail_setting()
    {
        return $this->hasOne('App\Models\Organization\MailSetting', 'organization_id', 'id');
    }

    public function members()
    {
        return $this->hasMany('App\Models\Member');
    }

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function documents()
    {
        return $this->hasMany('App\Models\Document');
    }

    public function schedule_mails()
    {
        return $this->hasMany('App\Models\ScheduleMail');
    }
}
