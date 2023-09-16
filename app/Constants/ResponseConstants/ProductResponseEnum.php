<?php

namespace App\Constants\ResponseConstants;

enum ProductResponseEnum:string implements ResponseInterface{
    case PRODUCT_CREATE = "Product created successfully";
    case PRODUCT_SHOW = "Product information";
    case PRODUCT_UPDATE = "Product updated successfully";
    case PRODUCT_DELETED = "Product deleted successfully";
}
