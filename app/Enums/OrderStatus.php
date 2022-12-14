<?php

namespace App\Enums;

enum  OrderStatus : string
{
    case Unpaid     = 'unpaid'; //draft
    case Paid       = 'paid';
    case Completed  = 'complete'; //admin
}
