
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'src',
    ];

    protected $table = 'images';

    public function vegetable()
    {
        return $this->belongsTo(Vegetable::class);
    }
}
