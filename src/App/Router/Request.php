<?php

namespace App\Router;

class Request
{
    private string $url;
    private string $method;
    private string $query;

    public function __construct()
    {
        $this->url = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $this->url .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_SERVER['QUERY_STRING'];
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getQuery(): string
    {
        return $this->query;
    }
}