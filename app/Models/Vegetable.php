<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Activeable;
use App\Models\Traits\Filterable;

class Vegetable extends Model
{
    use Activeable, Filterable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'is_actived',
    ];

    protected $table = 'vegetables';

    public function images()
    {
        return $this->belongsToMany(Image::class);
    }
}
