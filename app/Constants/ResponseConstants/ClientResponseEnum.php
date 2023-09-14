<?php

namespace App\Constants\ResponseConstants;
    enum ClientResponseEnum:string implements ResponseInterface{
        case CLIENT_CREATE = "Client created successfully";
        case CLIENT_SHOW = "Client information";
        case CLIENT_UPDATE = "Client updated successfully";
        case CLIENT_DELETE = "Client deleted successfully";
}
