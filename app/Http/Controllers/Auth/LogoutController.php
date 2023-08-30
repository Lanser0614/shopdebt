<?php

namespace App\Http\Controllers\Auth;

use App\Constants\ResponseConstants\AuthResponseEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke()
    {
        return $this->execute(function (){
            auth()->user()->tokens()->delete();
        }, AuthResponseEnum::USER_LOGOUT);
    }
}
