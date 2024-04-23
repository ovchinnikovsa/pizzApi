<?php

namespace App\Controller;

use App\View\Json;

abstract class ApiController
{
    public static function send(array $data): void
    {
        Json::send($data, 200);
        die();
    }

    public static function sendError(array $data, int $code = 400): void {
        Json::send($data, $code);
        die();
    }
}