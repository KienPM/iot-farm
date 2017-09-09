<?php

namespace App\Models\Traits;

trait Activeable
{
    public function scopeActive($query)
    {
        return $query->where('is_actived', true);
    }

    public function isActive()
    {
        return $this->is_actived;
    }
}
