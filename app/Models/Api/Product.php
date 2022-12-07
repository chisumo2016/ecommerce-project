<?php
declare(strict_types=1);

namespace App\Models\Api;


class Product extends \App\Models\Product
{


    public  function  getRouteKeyName()
    {
        return 'id';
    }
}
