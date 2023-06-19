<?php

namespace App\Http\Controllers;


use App\Services\ContextualBindingBService;

class ContextualBindingBController extends Controller
{
    public function __invoke(ContextualBindingBService $contextualBinding)
    {
        return $contextualBinding->get();
    }
}
