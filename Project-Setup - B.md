#### PART B: CONNECT  VUE.JS ADMIN PANEL TO LARAVEL API 
                declare(strict_types=1);
        CREATE ADMIN USER SEEDER 
            
        To implemennt the User login  (is_admin )
            php artisan make:migration add_is_admin_column_to_users_table     
            php artisan migrate
        Create a Seeder
            php artisan make:seeder AdminUserSeeder 
            php artisan db:seed  --class=AdminUserSeeder 
            php artisan migrate:fresh 
            php artisan db:seed  --class=AdminUserSeeder 

       


         
        
    






        
















            
        
        

























            



























