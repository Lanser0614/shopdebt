<?php

namespace App\Constants\ResponseConstants;

enum AuthResponseEnum:string implements ResponseInterface{
    case USER_LOGIN = "User successfully logged in";
    case USER_REGISTER = "User successfully registered";
    case USER_LOGOUT = "User successfully logged out";
}
