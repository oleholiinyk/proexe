<?php

namespace App\Services;

use App\Http\Middleware\JwtToken;
use App\StaticData\PrefixStatic;
use External\Bar\Auth\LoginService;
use External\Baz\Auth\Authenticator;
use External\Foo\Auth\AuthWS;

class AuthService
{
    protected $loginService;
    protected $authenticator;
    protected $authWS;

    public function __construct(
        LoginService $loginService,
        Authenticator $authenticator,
        AuthWS $authWS
    ) {
        $this->authWS = $authWS;
        $this->authenticator = $authenticator;
        $this->loginService = $loginService;
    }

    public function login(string $login, string $password, string $host): array
    {
        if (!$this->checkPrefixLogin($login, $password)) {
            return [
                'status' => 'failure',
                'token' => '<generated token>'
            ];
        }
        $jwtToken = new JwtToken();
        return [
            'status' => 'success',
            'token' => $jwtToken->handle($host, $login)
        ];
    }

    protected function checkPrefixLogin(string $login, string $password): bool
    {
        $prefixUser = strtok($login, '_');
        $logged = false;
        switch ($prefixUser) {
            case $prefixUser == PrefixStatic::BAZ:
                try {
                    if($this->authenticator->auth($login, $password)) {
                        $logged = true;
                    }
                } catch (\Exception $e) {
                    $logged = false;
                }
                break;

            case $prefixUser == PrefixStatic::FOO:
                try {
                    if(is_null($this->authWS->authenticate($login, $password))) {
                        $logged = true;
                    }
                } catch (\Exception $e) {
                    $logged = false;
                }
                break;

            case $prefixUser == PrefixStatic::BAR:
                try {
                    if ($this->loginService->login($login, $password)) {
                        $logged = true;
                    }
                } catch (\Exception $e) {
                    $logged = false;
                }
                break;

        }
        return $logged;
    }
}
