<?php

namespace App\Constants\ResponseConstants;

enum SellerResponseEnum:string implements ResponseInterface{
    case SELLER_CREATE = "Seller created successfully";
    case SELLER_SHOW = "Seller information";
    case SELLER_UPDATED = "Seller updated successfully";
    case SELLER_DELETED = "Seller deleted successfully";
}
