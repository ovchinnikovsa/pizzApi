<?php

namespace App\Router;

use App\Controller\StaticController;
use App\Router\Request;

class Router
{
    private $routes = [];
    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function __destruct()
    {
        $this->handleRequest();
    }

    public function get($uri, $handler)
    {
        $this->addRoute('GET', $uri, $handler);
    }

    public function post($uri, $handler)
    {
        $this->addRoute('POST', $uri, $handler);
    }

    private function addRoute(string $method, string $uri, array $handler)
    {
        $this->routes[] = [
            'method' => $method,
            'uri' => $uri,
            'handler' => $handler
        ];
    }

    private function handleRequest()
    {
        $handler = $this->resolveHandler();
        if ($handler) {
            try {
                call_user_func_array($handler, []);
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

    public function resolveHandler(): string
    {
        $uri = $this->request->getQuery();
        $current_route = array_filter($this->routes, function ($route) use ($uri) {
            $routePattern = $route['uri'];
            $routePattern = preg_replace('{\w+}', '(\w+)', $route['uri']);
            $routePattern = str_replace('/', '\/', $route['uri']);
            return preg_match($routePattern, $uri);
        });

        return count($current_route) ? $current_route[0]['handler'] : null;
    }
}
