<?php

namespace App\Services;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Application;

class BindExtendService
{
    /**
     * @throws BindingResolutionException
     */
    public function get()
    {
        app()->extend(BindService::class, function (BindService $service, Application $app) {
            return new BindService('from bind extend service');
        });

        /** @var $bindService BindService */
        $bindService = app()->make(BindService::class);

        return $bindService->get();
    }
}
