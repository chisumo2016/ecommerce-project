<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\ReportTrait;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use ReportTrait;


    public function orders()
    {
        $fromDate = $this->getFromDate();
        $query = Order::query()->get();

        if($fromDate){
            $query->where('created_at','>' , $fromDate);
        }

        return $query->get();

    }

    public  function  customers()
    {

    }
}
