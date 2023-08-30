<?php

namespace App\Constants\ResponseConstants;

enum UserResponseEnum:string implements ResponseInterface{
    case USERS_LIST = 'Users list';
    case USER_CREATE = 'User successfully created';
    case USER_SHOW = 'User information';
    case USER_UPDATE = 'User updated successfully';
    case USER_DELETE = 'User deleted successfully';
}
