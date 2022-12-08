### SHOPPING CART FUNCTIONALITY 

## CREATE CART HELPER WITH REUSABLE METHODS 
    Work on cart management with Laravel .
        Adding the items into the cart.
        Changing their quantities.
        Removing items from the cart.
        Whenever ur a guest , you can add thee items to the cart (NEW FEATURES).
        But after you login / register ,your items into the cart  get associate to ur account.
        Before the user is registered, we gonna save the items into cookies, user can navigate btn pages , close the browser and comeback later.
            The cart item will be still in cookies
        If user deecide to procede with registtration/ loogin , then these items which are in the cart needs to move to 
            its account, we gonna have them into the database (cart_items table) .
                example: id, user_id, product_id , quantity.
    We gonna do alot of steps 
            1: create Helpers directory   
                app/Http/Helpers
                create a class called Cart.php 
                
            2: Create a CartController
                 php artisan make:controller CartController  
            3: Create a cart/index.blade.php
                    use the default x-app-layout
            4: In helper class , we're going to create five method 
                    1: Display the items we have into the cart, in the header navigation.
                            getCartItemsCount(): int{}
                    2: Return an array of cart we have , user is authorized
                            getCartItems(){}
                    3: Will return thee cart items we have in the cookie
                            getCookieCartItems()
                    4: Will accept the $cartItems, return the count from there.
                            getCountFromItems($cartItems)
                        why do we needd this ? why not call getCookieCartItems, getCartItems  and calculate how many items we have there?
                        We will understtand them when we go to controller . Whenever we update thee counter in the cookiess
                            
                    5: Whenever the user register or loggged in the system or authorized ,we will take the cart items
                        wchich the user has in ccookie and move them into database.
                            moveCartItemsIntoDb(){}

                            Inside cookie  QUANTITY      DB      QUANTITY
                    user has item       1  3             1           2
                                        2  1             4           1
                                        3  1
                             we have to take all cookie into database after aouthorized

                            ---------USER IS AUTHORIZED------- FINAL RESULT INN THE DATABASE
                                            DB      QUANTTITY
                                            1           2
                                            2           1
                                            3           1
                                            4           1
            All the five resusable method has been implemented .Time to work on Cart Coontroller

### CREATE CART CONTROLLER
    We will need four methods in CartConttroller
         1: index ()
            Not matters are inn the cookies or database
         2: add ()
         3: remove ()
         4: updateQuantity

    Let us starts implementinng these steps by steps from top to down
         1: index ()  - done
            Two ways to show the totals
                Alpine.js
        

    Read the logic carefully and understand the flow

### PREPARE API ROUTES FOR CART MANAGEMENT 
    Create a middleware in web route
            Route::middleware(['guestOrVerified'])->group(function (){

            });
    Create all four web routes inside the cart

### CREATE A MIDDLEWARE guestOrVerified
    create a middleware via terminal
        php artisan make:middleware guestOrVerified 
    
    Extends to EnsureEmailIsVerified
    Write a logic inside the middlware
    Register the middlware in kernel file

### PREPARE JAVASCRIPT FOR ADD TO CART
    Let us open the app.js file
    We dont need id , gonna use slug in app.js
    Implemennt some methods
    Create anothe file called http.js   resources/js/http.js,
    No third package will be used , 
    Inside the http.js file will axcept three methods
            request()
            get()
            post()
    Get and Post will call the request
    Implement the logic in the http.jss file 
    Return to app.jss and implement all the methods
    

### IMPLEMENT ADDING ITEMS INTO CART 
    Let open the product index file resources/views/product/index.blade.php
            x-data="productItem({{ json_encode([
                        'id'     => $product->id,
                        'slug'   => $product->slug,
                        'image'  => $product->image,
                        'title'  => $product->title,
                        'price'   => $product->price,
                        'addToCartUrl' => route('cart.add', $product) will take $product slug
                    ]) }})"
    We don't need the to passs the id , as it available product itself
    Add the route in navigation
    aadd the addition helper
                 x-data="{
                    mobileMenuOpen: false,
                    cartItemsCount: {{ \App\Http\Helpers\Cart::getCartItemsCount()}}
                    }"

                    <small
                        x-show="$store.header.cartItems"
                        x-transition
                        x-text="$store.header.cartItems"
                        class="py-[2px] px-[8px] rounded-full bg-red-500"
                    ></small>
                     <small
                        x-show="cartItemsCount"
                        x-transition
                        x-text="cartItemsCount"
                        class="py-[2px] px-[8px] rounded-full bg-red-500"
                    ></small>
    We need to listen on cart_change' ->navigation blade
             @cart_change.window ="cartItemsCount = $event.detail.count"
            PROBLEM:
                FLUSTH MESSAGE DOESN'T SHOW UP
                WHEN I ADD THE CART, ITEM ADDED WILL BE SEEN AFTER REFRESHING THE PAGE

                if (response.status > 200 && response.status < 300){
                    return response.json() //return promise
                }
            SOLUTION:
                if (response.status >= 200 && response.status < 300){
                            return response.json() //return promise
                        }
             php artisan  cache:clear   
             php artisan view:clear  

### CREATE CART PAGE PART 1 
    Copy the code from the theme 
    Write the code on template  from x-data of alpine
    Run tthe aalpine for loop on the template
            <template x-if="cartItems.length"></template>
        Checking if there's one cartitemm x-if="cartItems.length"
    Let us the alpine to display the information
    All logic in the cart/index.blade.php
        updating the quantity
        Removing the items into the ca
        

### CREATE CART PAGE PART 2 
    We need to implemented the total quantity into  the cart
    Uer the function creeted to get tthe total and use alpine to display
            x-text="`$${cartTotal}`">
    Add :key="product.id" in the x-for loop



### SHOW CART SUBTOTAL AND CHECKOUT BUTTON  
### IMPLEMENT ADD TO CART FROM PRODUCT INNER PAGE 






















