<?php

namespace App\Http\Controllers;

use App\Services\ContextualBindingAService;

class ContextualBindingAController extends Controller
{
    public function __invoke(ContextualBindingAService $contextualBinding)
    {
        return $contextualBinding->get();
    }
}
