<?php

namespace App\Services;

use App\Repositories\ContextualBindingRepositories;

class ContextualBindingAService
{
    private string $value;

    public function __construct(private readonly ContextualBindingRepositories $contextualBindingRepositories, $value = 'default')
    {
        $this->value = $value;
    }

    public function get(): string
    {
        return "value from $this->value: ContextualBindingService, rep: {$this->contextualBindingRepositories->get()}";
    }
}
