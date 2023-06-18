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
}
