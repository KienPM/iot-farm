<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Storage;

/**
 * App\Models\Image
 *
 * @property int $id
 * @property string $title
 * @property string $src
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Vegetable $vegetable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Image whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'src', 'entityable_id', 'entityable_type',
    ];

    protected $table = 'images';

    public function entityable()
    {
        return $this->morphTo();
    }

    public function getSrcAttribute($value)
    {
        if ($this->entityable_type == Vegetable::class) {
            $imageSrc = 'public/' . config('upload.path.vegetables_image') . '/' . $value;
            if (Storage::exists($imageSrc)) {
                return Storage::url($imageSrc);
            }

            return 'public/' . config('upload.path.default') . '/' . config('upload.default.vegetables_image');
        }

        return $value;
    }
}
