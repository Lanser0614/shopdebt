<?php

namespace App\Constants\ResponseConstants;

enum SearchResponseEnum:string implements ResponseInterface{

    case GLOBAL_SEARCH = "Search results by params";
}
