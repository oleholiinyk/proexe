<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\AuthTokenResoource;
use App\Services\AuthService;

class AuthController extends Controller
{
    /**
     * @param  LoginRequest  $request
     * @param  AuthService  $service
     * @return AuthTokenResoource
     */
    public function login(LoginRequest $request, AuthService $service): AuthTokenResoource
    {
        return AuthTokenResoource::make($service->login($request->get('login'), $request->get('password'),
            $request->getHost()));
    }

}
