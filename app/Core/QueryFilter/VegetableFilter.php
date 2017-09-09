<?php

namespace App\Core\QueryFilter;

use Carbon\Carbon;

class VegetableFilter extends BaseFilter
{
    protected $masterTable = 'vegetables';

    protected $quickSearchFields = ['name', 'description'];
}
