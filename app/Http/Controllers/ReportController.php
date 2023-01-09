<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Traits\ReportTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    use ReportTrait;


    public function orders()
    {
        $fromDate = $this->getFromDate() ?: Carbon::now()->subDay(30);
        $query = Order::query()
            ->select([DB::raw('CAST(created_at as DATE) AS day'), DB::raw('COUNT(created_at) AS count')])
            ->groupBy(DB::raw('CAST(created_at as DATE)'));
        if($fromDate){
            $query->where('created_at','>' , $fromDate);
        }

        /**Order will be an associative array*/
        $orders = $query->get()->keyBy('day');;

        /**Process for chartjs*/
        $days = [];
        $labels = [];
        $now = Carbon::now();
        while ($fromDate < $now) {
            $label = $fromDate->format('Y-m-d');
            $labels[] = $label;
            $fromDate = $fromDate->addDay(1);
            $days[] =  isset($orders[$label]) ? $orders[$label]['count'] : 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label'=> 'orders By Day',
                'backgroundColor' => '#f87979',
                'data' => $days
            ]]
        ];

    }

    public  function  customers()
    {

    }

    private function fillGaps(Collection|array $orders)
    {
        /**Return received order*/
        return $orders;
    }
}
