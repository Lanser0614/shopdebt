<?php

namespace App\Constants\ResponseConstants;

enum ShopResponseEnum:string implements ResponseInterface{
    case SHOP_INDEX = "Shops List";
    case SHOP_CREATE = "Shop created successfully";
    case SHOP_INFO = "Shop information";
    case SHOP_UPDATE = "Shop updated successfully";
    case SHOP_DELETE = "Shop deleted successfully";
    case SHOP_SELLERS = "Shop sellers";
    case SHOP_CLIENTS = "Shop clients list";
    case SHOP_PRODUCTS = "Shop products list";
}
