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
        if ($this->method === 'POST' && empty($_POST)) {
            $this->postData = json_decode($this->getInput(), true) ?? [];
        }
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

    public function getGetData(string $key): mixed
    {
        return $this->getData[$key] ?? null;
    }

    public function getPostData(string $key): mixed
    {
        return $this->postData[$key] ?? null;
    }

    public function getInput(): string
    {
        return file_get_contents('php://input');
    }
}