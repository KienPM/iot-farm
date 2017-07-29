<?php

namespace App\Core\QueryFilter;

use App\Models\Store;
use Carbon\Carbon;

class StoreFilter extends BaseFilter
{
    protected $masterTable = 'stores';

    protected $quickSearchFields = ['address', 'info'];
}
