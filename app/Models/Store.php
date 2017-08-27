<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Filterable;
use App\Models\Traits\Activeable;

/**
 * App\Models\Store
 *
 * @property int $id
 * @property int $partner_id
 * @property string $address
 * @property string|null $info
 * @property float|null $longitude
 * @property float|null $latitude
 * @property int $is_actived
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Device[] $devices
 * @property-read \App\Models\Partner $partner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Vegetable[] $vegetables
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store filterBy(\App\Core\QueryFilter\QueryFilter $queryFilter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereIsActived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Store whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
            ->withPivot(['id', 'price']);
    }
}
