#### START WORKING ON WEBSITE FRONTEND

## DOWNLOAD THE FRONTEND THEME
    Let us start working on client side 
        https://github.com/thecodeholic/tailwindcss-ecommerce

## INSTALL LARAVEL BREEZE
    - Start kits for laravel authentication
        https://laravel.com/docs/9.x/starter-kits
    Installation steps
            composer require laravel/breeze --save --dev
            php artisan breeze:install
            php artisan migrate
            npm install
            npm run dev
    Previous  laravel was using the mix but now is larave vite , building laravel assests
    Laravel Breeze comes with two layers,  
                    Authorizeed users and 
                    Non authorized users

### INTEGRATE E-COMMERCE THEME INTO LARAVEL
    We have two layouts 
                app.blade.php   - for authorized user
                guest.blade.php - for non authorized user
    I am going to use the app blade and moddify it
        Take some code from app and paste into scratch file
        Install via npm
                alpinejs/persist@3.10.2
                alpinejs/collapse@3.10.2
                aalpinejs@3.10.2/
         npm install -D @alpinejs/persist @alpinejs/collapse 
        Install these packages
                npm install @tailwindcss/forms @tailwindcss/aspect-ratio 
        Open the tailwindcss.config.js 
                plugins: [
                    require('@tailwindcss/forms'),
                    require('@tailwindcss/aspect-ratio')
                ],

### CREATE LOGIN FORM WITH THEME DESIGN
    Edit our login from laravel breeze , use ours
    Open the login.blade.php , uses the guest layout, gona change to use <x-app-layout><x-app-layout>
    Open our theme project, copy the form
    Change the <input> to x-input
    Two way to show the alert on the form
        At the top 
        Below input field
    The nnew laravel 9 , the x-inpuut <x-auth-vvalidation-error  doesn't exist
    Also unable to write those classes , where should i write?

### CREATE PASSWORD RESET FORM
    comppare with forgot-password.blade.php with new one  password-reset.html
    Problem is showinng the validation errors

###  CREATE SIGNUP FORM
     comppare with register.blade.php with new one  signup.html
    Problem is showinng the validation errors

###  RENDER PRODUCTS ON WEBSITE 1
    Create a ProductController  
         php artisan make:controller ProductController 
    Write the function index () on ProductController
    Loop over on index.blade

###  RENDER PRODUCTS ON WEBSITE 2
    Add the aspect ratio in index.blade.php on the image 
    Add the pagination at the bottom

### SEND EMAIL ON CUSTOM REGISTRATION
    Send an email when the user is registered /create an account  0843 178 5555
    Use Mailtrap
        add the crediantial on the env file
    Open User Model 
        implement the interface MustVerifyEmail
    Open the web route 
        add the middleware(['auth', 'verified'])
    try to send
    Modifify our template
        <x-guest-layout> TO
        <x-app-layout>


### CUSTOMIZE EMAIL TEMPLATES
    php artisan vendor:publish --tag=laravel-mail  
        views->vendor->mail
                resources/views/vendor/mail/html/themes/default.css
    MAKE auth to adapt the app layer from guest 

### CREATE EMPTY PRODUCT PAGE
    To show the single product
    Create a function show in productcontroller
    Add the route in web file, gonna usse slug, we need to change some few things in Produc model
    Opeen the product/index file addd on the link to display single items
            index.blade.php
             href="{{ route('product.show', $product->slug) }}"
                echo '<pre>';
            var_dump($product);
        echo '</pre>';
    Slight we nneed to update the backend of the view ,innstead of id to use slug
        Two ways 
            To be done on vue side
            To have two product models
                Model for backend api
                Model for front end
    We need to use the Model on Api ProductController
        use App\Models\Product; to use App\Models\Api/Product;

    OR 

    Open the action.js, loook for getProduct method
            
    









    

    
    

