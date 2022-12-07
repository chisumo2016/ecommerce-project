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

###  RENDER PRODUCTS ON WEBSITE
    Create a ProductController  
         php artisan make:controller ProductController 
    

    
    

