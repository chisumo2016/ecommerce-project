<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Http\Helpers\Cart;
use App\Mail\NewOrderMail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $orderItems = [];
        foreach ($products as $product){
            $quantity = $cartItems[$product->id]['quantity'];
            $totalPrice += $product->price * $quantity;
            $line_items[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $product->title,
                        //'images' => [$product->image], /accessible local server
                    ],
                    'unit_amount' => $product->price * 100,
                ],
                'quantity' => $quantity,
                //'quantity' => $cartItems[$product->id]['quantity'],
            ];

            /**Push */
            $orderItems[] = [
                /**DB Field*/
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
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

        /**Create Order*/
        $orderData = [
            'total_price' => $totalPrice ,
            'status'      => OrderStatus::Unpaid,
            'created_by'  => $user->id,
            'updated_by'  => $user->id,

        ];

        /**Create ana Order*/
        $order = Order::create($orderData);

        /**Create Order Items*/
        foreach ($orderItems as $orderItem){
            $orderItem['order_id'] = $order->id;
            OrderItem::create($orderItem);
        }


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

        /**Empty the cart*/
        CartItem::where(['user_id' =>$user->id])->delete();

        return redirect($checkout_session->url);

    }
    public  function  success(Request $request)
    {
        /** @var \App\Models\User $user*/
        $user = $request->user();

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        try {
            $session_id = $request->get('session_id');

            $session  = $stripe->checkout->sessions->retrieve($session_id);

             if (!$session){
                 return view('checkout.failure', ['message' => 'Invalid Session ID']);
             }
            /** Query payment from DB**/
            $payment = Payment::query()
                ->where(['session_id'=> $session_id])
                ->whereIn('status',[PaymentStatus::Pending, PaymentStatus::Paid] )->first();
            if (!$payment){
                throw  new NotFoundHttpException();
                //return view('checkout.failure',['message' => 'Payment Does not exist']);
            }

            if ($payment->status === PaymentStatus::Pending->value){

                $this->updateOrderAndSession($payment);
            }

            $customer = $stripe->customers->retrieve($session->customer);
            return view('checkout.success', compact('customer'));

        }catch (NotFoundHttpException $e){
            throw $e;
        }
        catch (\Exception $e){
            //throw $e;
            return view('checkout.failure',['message' => $e->getMessage()]);
        }

    }

    public  function  failure(Request $request)
    {
        return view('checkout.failure',['message' => ""]);
    }

    public function checkoutOrder(Order $order, Request $request)
    {
//        /** @var \App\Models\User $user*/
        //$user = $request->user();

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

        $lineItems = [];
        foreach ($order->items as $item ){
            $lineItems[] =[
                /**Push*/
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' =>$item->product->title,
                        //'images' => [$product->image], /accessible local server
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' =>$item->quantity,
            ];
        }

        $session = $stripe->checkout->sessions->create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url'   => route('checkout.success', [],true) . '?session_id={CHECKOUT_SESSION_ID}' ,
            'cancel_url'    => route('checkout.failure', [],true),
        ]);

        /**Update the session Id*/
        $order->payment->session_id = $session->id;
        $order->payment->save();

        return redirect($session->url);
    }

    public function webhook()
    {

        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));
        $endpoint_secret = env('WEBHOOK_SECRET_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 401);
            exit();
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 402);
            exit();
        }

            // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed': //payment_intent.succeeded
                $paymentIntent = $event->data->object;
                $sessionId  = $paymentIntent['id'];

                $payment = Payment::query()
                    ->where(['session_id'=> $sessionId, 'status' =>PaymentStatus::Pending ])->first();
                if ($payment){
                    $this->updateOrderAndSession($payment);
                }

            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    private  function  updateOrderAndSession(Payment $payment)
    {
        /**Payment exist*/
        $payment->status  = PaymentStatus::Paid->value;
        $payment->update();

        /**Take the Order of this payment */
        $order = $payment->order;

        $order->status = OrderStatus::Paid->value;
        $order->update();

        /**Sending Email*/
        $adminUsers = User::where('is_admin', 1)->get();
        /**Push */
       // $adminUsers[] =$order->user;

        foreach([...$adminUsers,$order->user] as $user){
            Mail::to($user)->send(new NewOrderMail($order, (bool)$user->is_admin));
        }

    }
}
