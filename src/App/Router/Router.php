<?php

namespace App\Router;

use App\Controller\StaticController;

class Router
{
    private $routes = [];

    public function __destruct()
    {
        $query = self::getParsedQuery();
        $this->handleRequest($query['method'], $query['params']);
    }

    public function addRoute($uri, $handler)
    {
        $this->routes[$uri] = $handler;
    }

    private function handleRequest($method, $params)
    {

        $handler = $this->routes[$method] ?? null;
        if ($handler) {
            try {
                call_user_func_array($handler, [$params]);
            } catch (\Exception $e) {
                StaticController::error([
                    'message' => $e->getMessage()
                ]);
            }
        } else {
            StaticController::error([
                'message' => 'Method not found'
            ]);
        }
    }

    private static function getCurrentUrl(): string
    {
        $url = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $url .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        return $url;
    }

    private static function getParsedQuery(): array
    {
        $url = parse_url(self::getCurrentUrl());

        $params = $url['path'] ?? '';
        $method = explode('/', $params);
        $method = $method[0] ?: $method[1];
        $method = $method === '' ? '/' : $method;

        return [
            'method' => $method,
            'params' => $params,
        ];
    }
}