<?php

namespace App\Http\Controllers\Core\Traits;

trait UserNormalTrait
{
    protected function identify()
    {
        return 'email';
    }
}
