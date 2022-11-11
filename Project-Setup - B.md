#### PART B: CONNECT  VUE.JS ADMIN PANEL TO LARAVEL API 
                declare(strict_types=1);
        variable annptatiion
        CREATE ADMIN USER SEEDER 
            
        To implemennt the User login  (is_admin )
            php artisan make:migration add_is_admin_column_to_users_table     
            php artisan migrate
        Create a Seeder
            php artisan make:seeder AdminUserSeeder 
            php artisan db:seed  --class=AdminUserSeeder 
            php artisan migrate:fresh 
            php artisan db:seed  --class=AdminUserSeeder 

        IMPLEMENT LOGIN AND LOGOUT FOR ADMIN IN LARAVEL
        To create the Auth Controller and implement the login and logoout
             php artisan make:controller AuthController
       Implement the logic for login and logout in AuthCountroller
        Open an api file 
        Logout will be called when the user is authorized
        Implement the midddlware
          php artisan make:middleware Admin 
            - check for authenticated user
            - then will allow the usser to procedee
          Regisgter the middlware
       


         
        
    






        
















            
        
        

























            



























