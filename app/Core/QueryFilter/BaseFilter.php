<?php

namespace App\Core\QueryFilter;

use Carbon\Carbon;

abstract class BaseFilter extends QueryFilter
{
    protected $avaiableFilters = [
        'quick_search' => 'quick_search',
        'order' => [
            'sort_by' => 'sort_by',
            'sort_type' => 'sort_type',
        ],
    ];

    protected $table;

    protected $quickSearchFields = [];

    public function filter()
    {
        foreach ($this->avaiableFilters as $filterKey => $value) {
            $this->{'apply' . studly_case($filterKey) . 'Filter'}();
        }
    }

    protected function applyQuickSearchFilter()
    {
        $pattern = $this->getFilterValue($this->avaiableFilters['quick_search']);
        if (!$pattern) {
            return true;
        }

        $pattern = strtolower(trim($pattern));

        return $this->builder->where(function ($query) use ($pattern) {
            foreach ($this->quickSearchFields as $field) {
                $query->orWhere("{$this->table}.{$field}", 'LIKE', "%{$pattern}%");
            }
        });
    }

    protected function applyOrderFilter()
    {
        $orderBy = $this->getFilterValue($this->avaiableFilters['order']['sort_by']) ?: 'id';
        $sortType = $this->getFilterValue($this->avaiableFilters['order']['sort_type']) ?: 'DESC';

        return $this->builder->orderBy("{$this->table}.{$orderBy}", $sortType);
    }
}
