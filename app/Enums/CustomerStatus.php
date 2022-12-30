<?php

namespace App\Enums;

/**
 * Class CustomerStatus
 *
 */
enum  CustomerStatus : string
{
    case Pending      = 'pending'; //draft
    case Active       = 'active';
    case Disabled     = 'disabled';

}
