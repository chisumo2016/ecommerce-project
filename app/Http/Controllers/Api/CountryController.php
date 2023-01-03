<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;

class CountryController extends Controller
{
    public  function  countries()
    {
        return CountryResource::collection(Country::query()->orderBy('name', 'asc')->get());
        //Country::query()->orderBy('name', 'asc')->get();
    }
}
