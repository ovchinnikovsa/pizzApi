<?php

namespace App\Validator;

use App\Router\Request;

abstract class Validator
{
    protected Request $request;
    protected string $method;

    public function __construct(Request $request, string $method)
    {
        $this->request = $request;
        $this->method = $method;
    }

    public function validateRequest(array $params): bool
    {
        if ($this->request->getMethod() !== $this->method) {
            return false;
        }

        return $this->validateRequestParam($params);
    }

    protected function validateRequestParam(array $params): bool
    {
        $data = $this->method === 'POST'
            ? $this->request->getPostData()
            : $this->request->getGetData();

        foreach ($params as $param) {
            if (!isset($data[$param]) || empty($data[$param])) {
                return false;
            }
        }

        return true;
    }

    protected static function isJsonValid(string $json): bool
    {
        return json_last_error() === JSON_ERROR_NONE && json_decode($json) !== null;
    }


}