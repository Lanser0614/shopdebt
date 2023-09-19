<?php

namespace App\Constants\ResponseConstants;

enum ContactResponseEnum: string implements ResponseInterface {
    case CONTACT_IMPORT = "Contacts imported successfully";
    case CONTACT_DELETE = "Contact deleted successfully";
    case CONTACT_UPDATE = "Contact updated successfully";
}
