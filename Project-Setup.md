#### STEP TO BUILD ECOMMERCE 

        - Configure the env to build an application
        - Git 
        - Create an application (name of appliication)
        - Connect the application with data base
        - Migration 
            php artisan migrate
        - Database Schema Eccommerce
                    1 - users
                    2 - products
                    3 - orders
                    4 - order-items   (Junction table btn order and Produuct) ?
                    5 - payments
                    6 - cart-items
                    7 - orders-details  (Unions btn customers and customer-addresses table)
                    8 - countries
                    9 - customers
                    10 - customer_addresses
        - Add the items into cart
        - Make Orders
        - Have order details
        - Make Payments
        - Have report


         GENERATE MODELS AND MIGRATIONS
        Always generate the table w/c doesn't have references to other table
            php artisan make:model  User    -m
            php artisan make:model  Product -m
            php artisan make:model  Order   -m
            php artisan make:model  Country -m
            php artisan make:model  CartItem -m
            php artisan make:model  OrderDetail -m
            php artisan make:model  OrderItem   -m
            php artisan make:model  Payment     -m
            php artisan make:model  Customer    -m
            php artisan make:model  CustomerAddress -m

         WRITE / DATA MODELLING  MIGRATIONS
                Research foreignIdFor , jsonb , foreign , foreignId
                Product
                Order
                Country
                CartItem 
                OrderDetail
                OrderItem
                Payment
                Customer
                CustomerAddress
         php artisan migrate
            



























