<?php

namespace App\Http\Controllers\Auth;

use App\Constants\ResponseConstants\AuthResponseEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Models\User;

class RegisterController extends Controller
{
    public function __invoke(RegisterRequest $request)
    {
        return $this->execute(function () use ($request){
            $validated = $request->validated();
            $validated['password'] = bcrypt($validated['password']);
            $user = User::query()->create($validated);
            $token = $user->createToken('api_token')->plainTextToken;
            return AuthResource::make(['user' => $user , 'token' => $token]);
        }, AuthResponseEnum::USER_REGISTER);
    }
}
