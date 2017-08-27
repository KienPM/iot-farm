<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SocialUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $provider
 * @property string $provider_user_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereProviderUserToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SocialUser whereUserId($value)
 * @mixin \Eloquent
 */
class SocialUser extends Model
{
    const AVAILABLE_SOCIAL_PROVIDER = [
        1 => 'facebook',
        2 => 'google',
    ];

    const FACEBOOK_ACCOUNT = 1;
    const GOOGLE_ACCOUNT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'provider', 'provider_user_token',
    ];

    protected $table = 'social_users';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
