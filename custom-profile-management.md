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
    php artisan migrate

### INSERT CUSTOMER IN DB ON REGISTRATION
    Let save the customer in the customer table
    Open the RegisteredUserController.php
        create new customer
        explode the user name
        $customer = new Customer();
        $names = explode(" ", $user->name); //zuru fares
        $customer->user_id    = $user->id;
        $customer->first_name = $names[0];
        $customer->last_name  = $names[1] ?? '';
        $customer->save();
    TTry to register and see in cusstomer table.

### CHANGE COUNTRIES STATE COLUMN INTO JSON
    To change the county states column into json
    php artisan make:migration change_countries_states_column_into_json

        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('states');
        });

        Schema::table('countries', function (Blueprint $table) {
            $table->json('states')->nullable();
        });

    
    














