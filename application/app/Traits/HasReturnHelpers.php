<?php

namespace App\Traits;

trait HasReturnHelpers
{
    public function jsonResponse($value)
    {
        echo(json_encode($value));
        exit;
    }
}