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

        INSTALL AND CONFIGURE AXIOS IN VUEJS
        We have done the backend ,now it time toi focus with front end siide with vuejs
        Open Login.VUE 
        install the client axis to send api in vue project 
            npm install -S axios  
        Create a new file called axios.js
                    backend/src/axios/axios.js
                baseURL : `${import.meta.env.VITE_API_BASE_URL}/api`
                VITE_API_BASE_URL - create this
                interceptors is special function w/c executed before the request is made.
                After the responsse is received
        Create VITE_API_BASE_URL file .  Please 
                https://vitejs.dev/guide/env-and-mode.html
        Please create two files .env and .env.examle
            VITE_API_BASE_URL = http://ecommerce-project.test
        After that we can focus on login.Vue file
             define property
                    loading ,
                    erroMsg
             define the object user
             Write the login  fuctionality .Then
             Open Store , create different files foor actions ,getters, mutations
             Open the actions and write the logic for login and logout
             Afrer that go to mutations, implement two functions one for setUser annd setToken 
            Go back in the index.js file of state 
                import actions and mutation , oject
                    actions:actions
            Test the application  : OK

            Open Navbar.vue components  , implemented the logout functionality
            Test the application: OK


        SHOW VALIDATION ERROR MESSAGE IN LOGIN FORM
            https://tailwindcss.com/docs/animation#spin
         In Login.vue file we need to disabled the loading and conditional class
            :disabled="loading"
            :class="{}"
        Cpoy the spinner from tailwindcss and paste before svg
        Remove import router from "../router"  use  import {useRouter} from "vue-router"; in Login.vue and NavBAR.vue
        We have the session but we need to dispaly the user information.
            AppLayout.vue
            Whenever the layout is onMounted
            state.dispatch('getUser')
            Add the getUser  in actions.js

       Display the error messsage when the password is incorrect in Login.vue file
                <div v-if="errorMsg" class="flex items-center justify-center py-3 px-5 bg-red-500 text-white rounded">
                    {{ errorMsg }}
                </div>
       
       

        ADD SPLASH SCREEN LOADER AND OUTPUT USER IN NAVBAR
        Display the name onn profile
        Have some details about the user.
        Create some user resource .
                php artisan make:resource UserResource
        Pass the UserResource() in AuthController
        Up[date the api route
        We need to access the user in the navbar, we should have computed property.
        Add this into UserResourcce  public  static  $wrap = false;
        Update the action.js
        Add the  loader in AppLayout.vue components
        
        

        






























       


         
        
    






        
















            
        
        

























            



























