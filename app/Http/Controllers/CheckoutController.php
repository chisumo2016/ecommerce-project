<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public  function  checkout(Request $request)
    {
        /** @var \App\Models\User $user*/
        $user = $request->user();

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        list($products, $cartItems) = Cart::getProductsAndCartItems();

        $line_items = [];
        $totalPrice = 0;
        foreach ($products as $product){
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        //'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $quantity,
                //'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }
        //dd($line_items);
       //dd(route('checkout.success', [],true), route('checkout.failure', [],true));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items,

            'mode' => 'payment',
            'success_url'   => route('checkout.success', [],true) . '?session_id={CHECKOUT_SESSION_ID}' ,
            'cancel_url'    => route('checkout.failure', [],true),
        ]);
        //dd($checkout_session->id);

        /**Orders*/
        $orderData = [
            'total_price' => $totalPrice ,
            'status'      => OrderStatus::Unpaid,
            'created_by'  => $user->id,
            'updated_by'  => $user->id,

        ];

        /**Create ana Order*/
        $order = Order::create($orderData);



        /***create PaymentData*/
        $paymentData = [
            'order_id' => $order->id,
            'amount'=> $totalPrice,
            'status'=>PaymentStatus::Pending,
            'type' => 'cc',
            'created_by'  => $user->id,
            'updated_by'  => $user->id,
            'session_id'  => $checkout_session->id,
        ];

        $payment = Payment::create($paymentData);

        return redirect($checkout_session->url);

    }
    public  function  success(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        try {
            $session_id = $request->$_GET['session_id'];

            $session  = $stripe->checkout->sessions->retrieve($session_id);
             if (!$session){

                 return view('checkout.failure');
             }

            /** Query payment from DB**/
            $payment = Payment::query()->where(['session_id'=> $session->id, 'status' => PaymentStatus::Pending ])->get();
            if (!$payment){
                return view('checkout.failure');
            }

            /**Payment exist*/
            $payment->status  = PaymentStatus::Paid;
            $payment->update();

            /**Take the Order of this payment */
            $order = $payment->order;
            echo '<pre>';
            var_dump($order);
            echo '</pre>';

            $order->status = OrderStatus::Paid;
            $order->update();


            $customer = $stripe->customers->retrieve($session->customer);

            return view('checkout.success', compact('customer'));

        }catch (\Exception $e){

            return view('checkout.failure');
        }



        //dd($session,$customer);

    }

    public  function  failure(Request $request)
    {
        dd($request->all());
    }
}
