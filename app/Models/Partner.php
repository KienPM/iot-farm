<?php

namespace App\Models;

/**
 * App\Models\Partner
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone_number
 * @property string $password
 * @property int $is_actived
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $activeStores
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Store[] $stores
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseUser filterBy(\App\Core\QueryFilter\QueryFilter $queryFilter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereIsActived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Partner whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Partner extends BaseUser
{
    const ITEMS_PER_PAGE = 10;

    protected $table = 'partners';

    public function activeStores()
    {
        return $this->hasMany(Store::class)->active();
    }

    public function stores()
    {
        return $this->hasMany(Store::class);
    }
}
