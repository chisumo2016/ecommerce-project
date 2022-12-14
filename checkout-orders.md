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
