<?php

namespace App\Enums;

enum  OrderStatus : string
{
    case Unpaid         = 'unpaid'; //draft
    case Paid           = 'paid';
    case Cancelled      = 'cancelled';
    case Shipped        = 'shipped';
    case Completed      = 'completed'; //admin

    public static  function getStatuses()
    {
        return [
            self::Paid,
            self::Unpaid,
            self::Cancelled,
            self::Shipped,
            self::Completed
        ];
    }
}
