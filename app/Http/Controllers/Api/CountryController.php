<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryController extends Controller
{
    public  function  countries()
    {
        Country::query()->orderBy('name', 'asc')->get();
    }
}
