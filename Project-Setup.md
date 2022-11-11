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

        PART A BUILDING VUE.JS ADMIN PANEL
        TAILWINDCSS SETUP
        
        npm init -y
        npm install -D tailwindcss
        npx tailwindcss init
        npx tailwindcss -i ./src/input.css -o ./dist/output.css --watch
                            INPUT                   OUTPUT(DIST FOLDER WILL BE CREATED)
        Tailwindcss css IntelliSense

        VUE  INSTALLATION
        npm create vite@latest   
        name: backend
         npm install
        
        INSTALL TAILWINDCSS TO VUE PROJECT -VITE
        Make sure your in backend folder
                v3.1.5
            https://tailwindcss.com/docs/guides/vite
        Installation done in backed folder of vue
        In the main.js import import './index.css'
        Run : npm run dev
        
       INSTALL VUEX AND CREATE STORE
            Installation done in backed folder of vue
            npm install -S vuex@next
            For exact version oof vuex use vue@4
            Create Stoore and use to our application
                backend/src/store/index.js
            Register Store into main.js by importing
                    import store from "./store";
                    .use(router)
            Test the store   backend/src/store/index.js
                    import {createStore} from "vuex";

                const  store = createStore({
                /**Specify Object*/
                
                    state:{
                        test: '1253'
                    },
                    getters:{},
                    actions:{},
                    mutations:{},
                });
                
                export  default  store;

            UI 
            import {computed} from "vue";
            import store from "../store";
            
            const  test = computed( () => store.state.test)

       INSTALL VUE-ROUTER AND CREATE ROUTES
        installation of vue-router
            npm install -S vue-router@next   
            For exact version oof vuex use vue@4
        Create a folder and file  backend/src/router/index.js 
        Register the router into main js
        Add routes in src/router/index.js 
        Create a folder called views
                - backend/src/views/Dashboard.vue
                - backend/src/views/Login.vue
        
        CREATE LOGIN FORM
            https://tailwindui.com/
            https://headlessui.com/
            https://github.com/tailwindlabs/headlessui
            npm install -D @headlessui/vue @heroicons/vue @tailwindcss/forms

        CREATE REQUEST PASSWORD RESET AND RESET PASSWORD PAGES
            Create a Views called RequestPasswordReset.vue
                        backend/src/views/RequestPassword.vue
                        backend/src/views/ResetPassword.vue
            Add the routes in router file. for both.

        CREATE LAYOUT FOR GUEST USERS
            In Guest Layout we have three views
            If you observe quickly  , all three template looks similar ,Login, RequestPassward and Reset Password
            Define the GuestLayout under component
            Copy all code from Login.vue and Paste into GuestLayout.vue
            To Identify the layoout
            Take form tag in GuestLayout and replace with SLOT
            To listen how form inn login once iss submitted
                1: Take the form and move to GuestLayoout and wrap into slot
                    <form class="mt-8 space-y-6" @submit.prevent="emit('submit')" method="POST">
                        <slot></slot>
                    </form>
                        const emit = defineEmits(['submit'])
                    to parents
                    <GuestLayout title="Sign in to your account" @submit="login">

            2 SECOND OPTION  (GUEST LAYOUT )
                In GuestLayout we have three views
                Is more generic
                To use the Guest layout and add the form to each component
                Attach thee GuestLaypout to each
            
        
        CREATE EMPTY LAYOOUT FOR AUTHORIZED USERSS 
            Copy and Paste GuestLayout and call AppLayout
            Used when we try to open th dashboard page 
                    Side bar nnavigation
                    Header
                    Footer
            Inject the router-view in AppLayout.vue , wee will have nested view in AppLayout.vue
            In ther router/index.js we are going to define parent root and children root
            Child root will bee appended to parent root http://localhost:5173/app/dashboard

        CREATE SIDEBAR  
            outer div elements, split into two parts 
                   1: Side bar 
                   2: Main section (Header and Main)
            Add the h-full 
                <div id="app" class="h-full"></div>
            Coding in the side bar

        CREATE THE NAVBAR

        CREATE AND IMPLEMENT SIDEBAR TOGGLE BUTTON
        In ToHeader.vue wee can listen, emit an event to the parents.
            <button @click="emit('toggle-sidebar')"</button>
            const emit = defineEmits(['toggle-sidebar'])

        In thee parent of APPLAYOUT.VUE
        We need to listen the  toggle-sidebar
                 <TopHeader @toggle-sidebar="toggleSidebar"></TopHeader>
        Write a function
        Give the sidebar  -ml-[200px]
        implement the logic on the method in AppLayout.vue
        Duplicate the Dashboard.vue and create Products.vue
        Add the routes in router/index.js
        Add the links in sidebar

       MAKE LAYOUT RESPONSIVE
        Let uss make some few changes in topHeader.vue, Rename into NavBar
        Work on responsive on siidebar.vuee using javasccript
        Add some logic to handlre the resposiveeness in AppLayout.vue

        HANDLE UNAOTHORIZED USERS TO REDIRECT TO LOGIN PAGE.
        Open stote file and define the user state
        In the router.js
                router.beforeEach((to, next )=>{
                
                })
            to: is the route w/c we want to navigate
            form: is the route w/c we navigate
            next: is the functiion w/c allow the navigation to another pagee
        Callback will be used to every navigation
        Add the meta:{} root path require authentication
                meta:{
                    requiresAuth:true
                }


            router.beforeEach((to, from, next )=>{
            if (to.meta.requiresAuth && !store.state.user.token){
            /**Call next*/
            next({name:'login'})
            }else {
            next()
            }
            });

        We can add meta  in login, request-password and reset-password
            meta:{
            requiresGuest:true
        }

        router.beforeEach((to, from, next ) =>{
            if (to.meta.requiresAuth && !store.state.user.token){
                /** Call next */
              next({name:'login'});
            }else if (to.meta.requiresGuest &&  store.state.user.token){
        
                     /**Call next*/
                next({ name: 'app.dashboard'});
            }else{
                next();
            }
        });

        CREATE NOT FOUND PAGE
        Access the path doesn't exist, or instead of empty page , show the not found page.
        Add  new routes in the router file notFound
        Create a NotFound.vue


         PART B: CONNECT  VUE.JS ADMIN PANEL TO LARAVEL API 
        
    






        
















            
        
        

























            



























