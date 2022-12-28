<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderListResource;
use App\Http\Resources\OrderResource;
use App\Mail\OrderUpdateMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $query = Order::query()
            ->where('id', 'like', "%{$search}%")
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);

        return OrderListResource::collection($query);

    }

    public  function  show(Order $order)
    {
        return new OrderResource($order);
    }

    public  function  getStatuses()
    {
        return OrderStatus::getStatuses();
    }

    public function changeStatus(Order $order , $status)
    {
        $order->status = $status;
        $order->save();

        /**Sending Email*/
        Mail::to($order->user)->send(new OrderUpdateMail($order));

        return response('' , 200);
    }
}
