<?php

namespace App\Controller;

use App\Controller\Controller;
use App\View\View;

class StaticController extends Controller
{
    public static function index(): void
    {
        self::close('index');
    }
    public static function auth(): void
    {
        self::close('auth', needBlock: false);
    }

    public static function mysql(): void
    {
        self::close('mysql', needBlock: false);
    }

    public static function error(array $data): void
    {
        self::close('error', $data);
    }

    protected static function view(string $page, mixed $data = null, bool $needBlock = true): string
    {
        $data = $data ?? [];
        return View::render($page, $data, $needBlock);
    }
}