<?php

namespace App\Auth;

class Auth
{
    private string $authKey;

    public function __construct()
    {
        $this->authKey = $this->parseIniFile()['authKey'] ?? '';
    }

    public function isAuthenticated(): bool
    {
        $requestAuthKey = $_SERVER['HTTP_X_AUTH_KEY'] ?? '';
        return $requestAuthKey === $this->authKey;
    }

    private function parseIniFile(): array
    {
        $iniFile = __DIR__ . '/auth.ini';
        $iniData = parse_ini_file($iniFile);
        return $iniData;
    }
}