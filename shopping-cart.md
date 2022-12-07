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

    Let us starts implementinng these steps by steps
         1: index ()  - done
            Two ways to show the totals
                Alpine.js
        









