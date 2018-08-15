<?php

namespace App\Models\Member\Invitation;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Encryption\Encrypter;
use App\Traits\Models\AuthorObservable;

class Link extends Model
{
    use AuthorObservable;

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
    protected $table = 'member_invitation_links';

    protected $fillable = [
        'organization_id',
        'email',
        'token',
        'expired_at',
        'created_by',
        'updated_by',
    ];

    protected $dates = [
        'expired_at',
    ];

    // Relashion
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
