<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service ;
    public function __construct(AuthService $service)
    {
        $this->service = $service ;
    }
    public function login(LoginRequest $request){
        $info = $this->service->login($request->validated());
        return $info['status'] == 'success'
            ? self::success(['access_token' => $info['token'] , 'token_type' => 'Bearer'])
            : self::error('Error Occurred' ,$info['status'] , $info['code'], [$info['errors']]);
    }
}
