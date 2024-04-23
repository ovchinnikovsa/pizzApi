<?php

namespace App\View;

class Json
{
    public static function encode($data): string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }


    public static function send(array $data, int $code = 200): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        if (empty($data))
            $data = ['no data'];
        echo self::encode($data);
    }
}