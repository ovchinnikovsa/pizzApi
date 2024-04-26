<?php

namespace App\Router;

use App\Controller\ApiController;
use App\Controller\StaticController;
use App\Exception\UserException;
use App\Router\Request;
use App\Validator\ValidatorFactory;

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
            'handler' => $handler,
        ];
    }

    private function handleRequest()
    {
        $route = $this->resolveHandler();
        if ($route && is_callable($route['handler'] ?? null)) {
            try {
                $this->callToHandlers($route);
            } catch (UserException $e) {
                ApiController::sendError([
                    'message' => $e->getMessage()
                ]);
            } catch (\PDOException $e) {
                ApiController::sendError([
                    'message' => 'Database error'
                ]);
            } catch (\Exception $e) {
                ApiController::sendError([
                    'message' => 'Error'
                ]);
            }
        } else {
            StaticController::error([
                'message' => 'Method not found'
            ]);
        }
    }

    private function callToHandlers(array $route): void
    {
        $controllerClass = $route['handler'][0] ?? null;
        $controllerMethod = $route['handler'][1] ?? null;
        $validator = ValidatorFactory::createValidator(
            $controllerClass,
            $this->request
        );
        $dto = $validator->validateMethod($controllerMethod);

        call_user_func_array($route['handler'], [$dto]);
    }

    private function resolveHandler(): array|null
    {
        $uri = $this->request->getQuery();
        foreach ($this->routes as $route) {
            if (!$this->resolveMethod($route['method']))
                continue;

            if (!$this->resolveUrl($uri, $route['uri']))
                continue;

            return $route;
        }

        return null;
    }

    private function resolveUrl(string $uri, string $routeUri): bool
    {
        $routePattern = $routeUri;
        $routePattern = preg_replace('/{\w+}/', '(.*?)', $routePattern);
        $routePattern = str_replace('/', '\/', $routePattern);
        $routePattern = '/^' . $routePattern . '\/*$/';

        $condition = preg_match($routePattern, $uri, $params);

        $variables = array_slice($params, 1);
        if (!empty($variables))
            $this->request->setQueryParam($variables[0]);

        return $condition === 1;
    }

    private function resolveMethod(string $method): bool
    {
        return $this->request->getMethod() === $method;
    }
}
