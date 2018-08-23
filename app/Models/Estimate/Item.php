<?php

namespace App\Models\Estimate;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Models\AuthorObservable;

class Item extends Model
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
    protected $table = 'estimate_items';

    protected $fillable = [
        'estimate_id',
        'name',
        'price',
        'quantity',
        'created_by',
        'updated_by',
    ];

    public function estimate()
    {
        return $this->belongsTo('App\Models\Estimate');
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
