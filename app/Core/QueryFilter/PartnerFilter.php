<?php

namespace App\Core\QueryFilter;

use Carbon\Carbon;

class PartnerFilter extends BaseFilter
{
    protected $masterTable = 'partners';

    protected $quickSearchFields = ['name', 'email', 'phone_number'];
}
