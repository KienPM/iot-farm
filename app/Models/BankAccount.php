<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BankAccount
 *
 * @property int $id
 * @property int $user_id
 * @property string $account
 * @property int $is_actived
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereIsActived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BankAccount whereUserId($value)
 * @mixin \Eloquent
 */
class BankAccount extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'account',
    ];

    protected $table = 'bank_accounts';
}
