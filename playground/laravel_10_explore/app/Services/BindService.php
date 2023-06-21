<?php

namespace App\Services;

class BindService
{
    protected $value;
    public function __construct($value)
    {
        $this->value = $value;
    }

    public function get()
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function callSelf(BindService $service): string
    {
        return 'call self: ' . $service->get();
    }
}
