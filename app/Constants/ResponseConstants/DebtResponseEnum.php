<?php

namespace App\Constants\ResponseConstants;

enum DebtResponseEnum:string implements ResponseInterface {
    case DEBT_CREATE = "Debt created successfully";
    case DEBT_SHOW = "Debt information";
    case DEBT_UPDATE = "Debt updated successfully";
    case DEBT_DELETE = "Debt deleted successfully";
    case DEBT_SEARCH = "Search results by params";
}
