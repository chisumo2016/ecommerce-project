<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        /** @var \App\Models\User $user*/
        $user = $request->user();

        $orders = Order::query()
            ->where(['created_by' => $user->id])
            ->OrderBy('created_at','desc')
            ->paginate(5);

        return view('order.index', compact('orders'));
    }

    public function show(Order $order)
    {
        /** @var \App\Models\User $user*/
        $user = \request()->user();

        if ($order->created_by != $user->id){
            return  response("You don't have permission to view this order",  403);
        }

        return view('order.show', compact('order'));
    }
}
