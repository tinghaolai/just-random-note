<?php

namespace App\Repositories;

use App\Interfaces\ContextualBindingInterface;

class ContextualBindingRepositories implements ContextualBindingInterface
{
    /**
     * @var mixed|string
     */
    private mixed $value;

    public function __construct($value = 'default')
    {
        $this->value = $value;
    }

    public function get(): string
    {
        return 'get from ContextualBindingRepositories, value: ' . $this->value;
    }
}
