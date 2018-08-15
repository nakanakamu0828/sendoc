<?php

namespace App\Models\Source;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\AuthorObservable;

class Payee extends Model
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
    protected $table = 'source_payees';

    protected $fillable = [
        'source_id',
        'detail',
        'created_by',
        'updated_by',
    ];

    public function source()
    {
        return $this->belongsTo('App\Models\Source');
    }

    public function created_by()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }

    public function updated_by()
    {
        return $this->belongsTo('App\Models\User', 'updated_by', 'id');
    }
}
