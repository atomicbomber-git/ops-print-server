<?php

namespace App\Traits;

trait HasReturnHelpers
{
    public function jsonResponse($value)
    {
        header('Content-Type: application/json');
        echo(json_encode($value));
        exit;
    }
}