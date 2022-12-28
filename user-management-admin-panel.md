#### USER MANAGEMENT IN ADMIN PANEL

## PREPARE USER CONTROLLER IN LARAVEL API ( API BACKEND)
    Will be similar with orders
    admin user will provide email and password for this in backennd
    New user will receive is account has been created.
    This is ur password ,you need to change the password
    
    - Copy the code from ProducttController in API folder
    - Change the code according
    - Create another user in api folder extend from outside.
    - Create UserListResource 
             php artisan make:resource UserListResource 
            UserListResource - Field from the database will be returned.
    Create UserRequest
            php artisan make:request CreateUserRequest  
    Create a UserResource
            php artisan make:resource UserListResource 
    But on this scenario we can use UserResource
    Remove the show method , as we dont have much details,
    Updating the password will optional
    Create UpdateUserRequest
            php artisan make:request UpdateUserRequest  
    Add the route in api.php
        
