### RENAME CUSTOMER ID INTO USER_ID
    This part is customer profile management system
    We need to register a customer when the user sign in .
    Customer id , should reference users id 
        Cuustomer :  User
            1     :  1  Relationship
    Add user_id into Customer table before that , run the package.
            composer require doctrine/dbal
            php artisan make:migration rename_customer_id_into_user_id 
    SCHEMA
             Schema::table('customers', function (Blueprint  $table){
                    $table->removeColumn('id', 'user_id');
                });


               public function down()
                {
                    Schema::table('customers', function (Blueprint  $table){
                        $table->removeColumn('user_id', 'id');
                    });
                }
        
