<?php

namespace App\Validator;

use App\Router\Request;

abstract class Validator
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract public function validateMethod(string $method);

    protected static function isJsonValid(string $json): bool
    {
        return json_last_error() === JSON_ERROR_NONE && json_decode($json) !== null;
    }


}