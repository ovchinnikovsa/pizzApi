<?php

namespace App\Router;

class Request
{
    private string $url;
    private string $method;
    private string $query;
    private string|int $queryParam;
    private array $postData;
    private array $getData;

    public function __construct()
    {
        $this->url = empty($_SERVER['HTTPS']) ? 'http' : 'https';
        $this->url .= "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->query = $_SERVER['QUERY_STRING'];
        $this->postData = $_POST;
        $this->getData = $_GET;
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

    public function setQueryParam(int|string $queryParam): void
    {
        $this->queryParam = $queryParam;
    }

    public function getQueryParam(): string
    {
        return $this->queryParam;
    }

    public function getGetData(): array
    {
        return $this->getData;
    }

    public function getPostData(): array
    {
        return $this->postData;
    }
}