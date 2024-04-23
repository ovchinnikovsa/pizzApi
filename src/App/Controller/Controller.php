<?php

namespace App\Controller;

abstract class Controller
{
    abstract protected static function view(string $page, mixed $data = null, bool $needBlock = true): string;

    protected static function close(string $page, mixed $data = null, bool $needBlock = true): void
    {
        echo static::view($page, $data, $needBlock);
        die();
    }
}