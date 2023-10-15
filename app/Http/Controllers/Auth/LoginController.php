<?php

namespace App\Http\Controllers\Auth;

use App\Constants\ResponseConstants\AuthResponseEnum;
use App\Constants\ResponseConstants\UserResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\AuthResource;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): Response|JsonResource|Application|ResponseFactory
    {
        return $this->execute(function () use ($request){
            if (auth()->attempt($request->validated())){
                $user = auth()->user();
                $token = $user->createToken('api-token')->plainTextToken;
                return AuthResource::make(['user' => $user, 'token' => $token]);
            }
            return throw new Exception('Unauthorized');
        }, AuthResponseEnum::USER_LOGIN);
    }
}
