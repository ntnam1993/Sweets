<?php

namespace App\Facades;

use App\Helpers\Util;
use Illuminate\Support\Facades\Facade;

class UtilFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Util::class;
    }
}
