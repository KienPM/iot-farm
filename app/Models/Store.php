<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Traits\Activeable;

class Store extends Model
{
    use Filterable, Activeable;

    const ITEMS_PER_PAGE = 10;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'partner_id', 'address', 'info', 'is_actived', 'latitude', 'longitude',
    ];

    protected $table = 'stores';

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function activeDevices()
    {
        return $this->devices()->active();
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function vegetables()
    {
        return $this->belongsToMany(Vegetable::class, 'vegetable_in_store')
            ->withPivot(['price']);
    }
}
