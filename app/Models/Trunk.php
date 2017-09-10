<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Activeable;

class Trunk extends Model
{
    use Activeable;

    const ITEMS_PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'store_id', 'is_actived',
    ];

    protected $table = 'trunks';

    public function status()
    {
        return $this->hasMany(TrunkStatus::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
