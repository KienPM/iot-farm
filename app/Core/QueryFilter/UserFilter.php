<?php

namespace App\Core\QueryFilter;

use Carbon\Carbon;

class UserFilter extends BaseFilter
{
    protected $masterTable = 'users';

    protected $quickSearchFields = ['name', 'email', 'phone_number'];
}
