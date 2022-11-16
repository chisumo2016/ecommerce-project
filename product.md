### IMPLEMENT PRODUCT CRUD  IN LARAVEL API
    We need to do couple of preparations.
    Install spite laravel slaggable packages
        composer require spatie/laravel-sluggable
    Add into Product Model the trait
    Generate Product Factory and Product Seeder
         php artisan make:seeder ProductSeeder  
         php artisan make:factory  ProductFactory   
    Call the product Factory into Product Seeder
    Open Database seed and call all  seeders
    RUN:  
        php artisan migrate:fresh --seed    

    Implement the CRUD via controller for api
        php artisan make:controller  ProductController --api --requests --model=Product   
    Generate the resources
         php artisan make:resource ProductResource 
         php artisan make:resource ProductListResource 
    What iss the purpose of resource ? 
        Is the layer btn the controoller and actual response which returns to the browser
    Implement the logic fisrt in ProductResource and ProductListResource 
    Implement the Login in ProductController
        - query on index
        -  write all the logic 
    Add the product api route in api file


#### CREATE VUEJS SPINNER COMPONENTS,
    make some tweets in backend folder, inn AppLayout.vue, 
    To make the components for spinner .
            backend/src/components/core/Spinner.vue
    Add the component in the AppLayout.vue file
    Create a file called state.js wiithin store and call it iin index.js


### CREATE PRODUCTS TABLE IN VUEJS
    Open the product file views   backend/src/views/Product.vue
    Go state.js in store folder define the prodducts object
    Then go to products.vue













