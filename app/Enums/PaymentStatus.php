<?php

namespace App\Enums;

enum  PaymentStatus : string
{
    case Pending    = 'pending'; //draft
    case Paid       = 'paid';
    case Failed     = 'failed'; //admin
}
