<?php

namespace App\Controller;

use App\View\View;

class StaticController
{
    public static function index(): void
    {
        self::view('index');
    }

    public static function error(array $data): void
    {
        self::view('error', $data);
    }

    protected static function view(
        string $page,
        mixed $data = null,
        bool $needBlock = true
    ): void {
        $data = $data ?? [];
        echo View::render($page, $data, $needBlock);
        die();
    }
}