<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public  function  index()
    {
        return view('cart.index');
    }
}
