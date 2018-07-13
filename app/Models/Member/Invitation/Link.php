<?php

namespace App\Models\Member\Invitation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;

class Link extends Model
{
    /**
     * テーブル
     *
     * @var string
     */
    protected $table = 'member_invitation_links';

    protected $fillable = [
        'organization_id',
        'email',
        'token',
        'expired_at',
    ];

    protected $dates = [
        'expired_at',
    ];

    // Relashion
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

    // Function
    public static function generateToken()
    {
        $token = null;
        while(is_null($token)) {
            $token = str_replace(['+', '/'], ['-', '_'], base64_encode(Encrypter::generateKey(app()['config']['cipher'])));
            if (Link::where('token', $token)->first()) $token = null;
        }

        return $token;
    }
}
