<?php

namespace App\Models\Traits;

use App\Core\QueryFilter\QueryFilter;

trait Filterable
{
    /**
     * Apply filtering conditions to the given query builder instance.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  QueryFilter $queryFilter
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterBy($builder, QueryFilter $queryFilter)
    {
        return $queryFilter->apply($builder);
    }
}
