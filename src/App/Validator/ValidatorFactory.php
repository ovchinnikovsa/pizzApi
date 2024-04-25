<?php

namespace App\Validator;

use App\Router\Request;

class ValidatorFactory
{
    public static function createValidator(
        string $controllerClass,
        Request $request
    ): Validator {
        $validatorClass = str_replace('Controller', 'Validator', $controllerClass);
        // $validatorClass = __NAMESPACE__ . '\\' . $validatorClass;

        if (!class_exists($validatorClass)) {
            throw new \RuntimeException("Validator class '$validatorClass' not found.");
        }

        return new $validatorClass($request);
    }
}
