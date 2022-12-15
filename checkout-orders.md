#### STRIPE CHECKOUT AND ORDERS

### STRIPE ONLINE PAYMENTS CHECKOUT PARTS 1 (Integration of third party API on checkout)
    We gonna  use payments using stripes
    Make sure you have an account with stripes first
    Look for php stripe github package
        https://github.com/stripe/stripe-php
            composer require stripe/stripe-php
        Open stripe documentation search accept-a-payment
                https://stripe.com/docs/payments/accept-a-payment
        Open the cart/index file UI resources/views/cart/index.blade.php
            - create a form 
            - add the route ('cart.checkout')
            - add csrf
            - create a web route of cart/checkout
            - add the secret key
                    $stripe = new \Stripe\StripeClient('sk_test_mV0c75C1WoERmJ0Du7NFc9ew');
            - Have the following key in .env file
                STRIPE_PUBLISHABLE_KEY=
                STRIPE_SECRET_KEY=

       In the checkout method of  cartController 
            public  function  checkout(Request $request)
    {
        $stripe = new \Stripe\StripeClient(getenv('STRIPE_SECRET_KEY'));

    }
     Thee line_items is what we have in the cart
            $cartItems = Cart::getCartItems();
            dd($cartItems);
        Have 
            items: array:5 [▼
                0 => array:2 [▼
                  "product_id" => 33
                  "quantity" => 5
    We need extract the code 
    We need to multiply the price by 100
         'unit_amount' => $product->price * 100,
    Display the image
            'images' => [$product->image],
    Make the checkout controller
        php artisan make:controller CheckoutController 
                checkout(){} 
                success(){}
                failure(){}
    Open web file php and add the routes
    Move the checkout method from cartconttroller to checkoutcontroller
    Move getProductsAndCartItems intto cart Heelper, should be static
                        $cartItems = Cart::getCartItems();

                    $ids = Arr::pluck($cartItems, 'product_id');
                    $products = Product::query()->whereIn('id', $ids)->get();
                    $cartItems = Arr::keyBy($cartItems, 'product_id');
                    return [$products,$cartItems];

            TOO
            $cartItems = self::getCartItems();

            $ids = Arr::pluck($cartItems, 'product_id');
            $products = Product::query()->whereIn('id', $ids)->get();
            $cartItems = Arr::keyBy($cartItems, 'product_id');
            return [$products,$cartItems];
    You can access the cart in the CartControoller 
        list($products,$cartItems) = $this->getProductsAndCartItems();
            TO
        list($products,$cartItems) = Cart::getProductsAndCartItems();
    To add the web routes
            Route::post('/checkout/success', [CheckoutController::class,'success'])->name('checkout.success');
            Route::post('/checkout/failure', [CheckoutController::class,'failure'])->name('checkout.failure');
    Make sure to implement the all methods in the CheckoutController(){}
    
    Testing section
        https://stripe.com/docs/testing
    Passed but redirected on [] .
    We need to figure out how tto fix

### ### STRIPE ONLINE PAYMENTS CHECKOUT PARTS 2 (Integration of third party API on checkout)
    READ : https://stripe.com/docs/payments/accept-a-payment
    READ : https://stripe.com/docs/payments/checkout/custom-success-page
    
    Print the session id in checkoutController(){}
    Pass the sessionId in success_url   
        'success_url'   => route('checkout.success', ['sessionId' => '{CHECKOUT_SESSION_ID}'],true) ,
        Route::get('checkout/success/:sessionId', [CheckoutController::class, 'success'])->name('checkout.success');

            OR
        'success_url'   => route('checkout.success', [],true) . '?session_id={CHECKOUT_SESSION_ID}' ,
        Route::get('checkout/success/', [CheckoutController::class, 'success'])->name('checkout.success');
    Write some logic in the success(){}
        We can display the sucess message, Your paymment has been succcessfull made
        We need to remove the item from the cart.

    Create folder calleed checkout
            resources/views/checkout/success.blade.php
            resources/views/checkout/failure.blade.php
    Clear / remove cart 
        logic innside the seccess(){}

#### STRIPE ONLINE PAYMENTS CHECKOUT PARTS 3 (Integration of third party API on checkout)
    We need to make a request once the payment has been done .
        orders   table
        payments table
        We need to save the session_id inside the payments table
        Payment is transaction which happened within stripe .
        Create migration to add session_id into payment
            php artisan make:migration add_session_id_to_payments_table
    Add the variable
            $totalPrice = 0;
    FInd the total 
            $totalPrice += $product->price;
    Pass the order inn the checkoutController
    Status - create an enum
                app/Enums/OrderStatus.php
                app/Enums/PaymentStatus.php
    Add mass assigment on order model
                echo '<pre>';
                 var_dump($order);
                echo '</pre>';

                
                echo '<pre>';
                var_dump($payment);
                echo '</pre>';
        
                exit;
    Set the relationship btn Payment and Order
    

### STRIPE ONLINE PAYMENTS CHECKOUT PARTS 4 (Integration of third party API on checkout) : REMOVE/CLEAR CARTITEMS
    Payment hass one order
    Single payment can't have multiple order.
    If we dont have a payment , we should make the status Pending.
    We can pass the message in the exception 
        return view('checkout.failure',['message' => $e->getMessage()]);
    We can pass message variable in a failure blade 
    Final process is to remove/delete the items from the cart : Bulk delete eloquent laravel
    This part shows how to clear the tthe CartItems (checkoutController)
         CartItem::where(['user_id' =>$user->id])->delete();

### CREATE ORDER LIST PAGE FOR CUSTOMERS
    Display all order for customerss
    Create a new route for orders in web file
    Create a new orderControoller
        php artisan make:controller OrderControllerphp artisan make:controller OrderController
    Write a logic on OrderController index(){}
    Create the orders/index UI ,use the theme. copy tthe container
    Link to navigation page
    Logic to dispay is paid 
        {{ $order->status === \App\Enums\OrderStatus::Paid->value ? 'bg-emerald-500' : 'bg-gray-500'}}">
            TO 
        $order->isPaid()
    The above method is written in Order Model

    Create a checkoutOrder function within checkoutController(){}
        Gonna get session id from uurl
        Add the new route  with the name checkout-order
        Gonnna get the session  from the order
        Has the relationship in the Order Model called payment(){}
        The session might expired , generate a new session when u click pay.
    Implemment the logic checkoutOrder(){}
        to create an OrderItems.

### IMPLEMENT PAYMENT FOR UNPAID ORDERS
    OrderItems needs to be created after order is created,
    To create an orderItems arrays $orderItems =[];
    Gonna push inside orderItems array
             $orderItems[] = [
                
            ];
    Add Mass Assigment to OrderItem
    Create a relationship on OrderItem Model  call order():BelongsTo{}
    Create a relationship Order Model call items():HasMany{}
    Create a relationship OrderItem Model call product():HasOne{}
    Update the session Id in the checkoutOrder(){}

        ERROR
            Stripe\Exception\nvalidRequestException
            The `line_items` parameter is required in payment mode.

### STRIPE WEBHOOKS PART 1
    When the User add the Item into the cart and procede with checkout , User click on Pay ,as sooner I get
     the button green and close the tab or electriicty cut off . The payment was completed but the redirect didnt work .If you reload
        the payments page in the database, pending
     But when user looks in the my ordeer , will see the unpaid ----Pay Button although the money has been taken
        to my account.

     For this ,Stripe has webhooks,  webhooks will trigger time to time. Stripe Dashboard search webhooks
          https://dashboard.stripe.com/test/webhooks
                    Add an endpoint - staging or production environment 
                    Test in a local envirnmoment - local development
     For our project we gonna use Test in a local envirnmoment, download CLI
            https://stripe.com/docs/stripe-cli
     Webhooks are triggered by stripes
    Create a route for webhooks
         Route::post('webhook/stripe', [CheckoutController::class, 'webhook'])->name('webhook.stripe');
    Create a webhook(){}  innside checkoutController

        TESTING WEBHOOOK TERMINAL 1
        stripe login
        stripe listen --forward-to http://ecommerce-project.test/webhook/stripe
            Sending Three Event
                 charge.succeeded
                 payment_intent.succeeded
                 payment_intent.created
                    Also will show 419 
        
        TESTING WEBHOOOK TERMINAL 2 TRIGGER
        stripe listen --forward-to http://ecommerce-project.test/webhook/stripe Will send event to Terminal 1

    Open app/Http/Middleware/VerifyCsrfToken.php disable the csrf token for webhook
                 protected $except = [
                    //
                    '/webhook/stripe'
                ];
    Your branch is ahead of 'origin/main' by 1 commit.

### STRIPE WEBHOOKS PART 2 REPEAT TO WATCH
    - Webhook trigger earlier before redirect

### CREATE ORDER DETAILS PAGE
    Add the function view() in orderController
    Make sure the order belongs to user
    Open Theme for Order Details
    Sort in orderController
    


                    
    
  
 

