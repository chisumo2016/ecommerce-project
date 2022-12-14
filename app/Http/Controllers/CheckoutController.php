<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public  function  checkout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        list($products, $cartItems) = Cart::getProductsAndCartItems();

        $line_items = [];
        foreach ($products as $product){
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        //'images' => [$product->image],
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $cartItems[$product->id]['quantity'],
            ];
        }
        //dd($line_items);
       //dd(route('checkout.success', [],true), route('checkout.failure', [],true));

        $checkout_session = $stripe->checkout->sessions->create([
            'line_items' => $line_items,

            'mode' => 'payment',
            'success_url'   => route('checkout.success', [],true) ,
            'cancel_url'    => route('checkout.failure', [],true),
        ]);

        return redirect($checkout_session->url);

    }
    public  function  success(Request $request)
    {

        dd($request->all());
    }

    public  function  failure(Request $request)
    {
        dd($request->all());
    }
}
