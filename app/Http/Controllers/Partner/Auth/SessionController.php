<?php

namespace App\Http\Controllers\Partner\Auth;

use App\Http\Controllers\Core\Traits\UserNormalTrait;
use App\Http\Controllers\Core\Auth\SessionController as BaseSessionController;

class SessionController extends BaseSessionController
{
    use UserNormalTrait;

    protected $guard = 'partner';

    protected function makeAuthClaims($user)
    {
        $stores = $user->stores()->select(['id', 'partner_id'])->get();

        return [
            'id' => $user->id,
            'name' => $user->name,
            $this->identify() => $user->{$this->identify()},
            'guard' => $this->getGuard(),
            'stores' => $stores->pluck('id'),
        ];
    }
}
