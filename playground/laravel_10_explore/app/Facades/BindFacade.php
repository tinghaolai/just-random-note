<?php

namespace App\Facades;

use App\Services\BindService;
use Illuminate\Support\Facades\Facade;

class BindFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return BindService::class;
    }
}
