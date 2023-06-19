<?php

namespace App\Services;

use App\Interfaces\ContextualBindingInterface;

class ContextualBindingBService
{
    private string $value;

    public function __construct(private readonly ContextualBindingInterface $contextualBindingRepositories, $value = 'default')
    {
        $this->value = $value;
    }

    public function get(): string
    {
        return "value from $this->value: ContextualBindingService, rep: {$this->contextualBindingRepositories->get()}";
    }
}
