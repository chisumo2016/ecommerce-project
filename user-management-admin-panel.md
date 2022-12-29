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
    Tested the api - OK
            http://ecommerce-project.test/api/users

### DISPLAY ADMIN USERS IN VUE.JS ADMIN PANEL 
    https://restful-api-design.readthedocs.io/en/latest/resources.html
    - Will be done in the backend of vue.js
    - Add the  path in router/index.js 
                {
                path: 'users',
                name:'app.users',
                component:Users
            },
    - Duplicate the Product vue folder  and call Users vue 
    -To edit 
            const DEFAULT_EMPTY_OBJECT = {
                        id: '' ,
                        title: '' ,
                        image: '' ,
                        description: '' ,
                        price: '' ,
                    }
            const DEFAULT_USER = {
                        id: '' ,
                        title: '' ,
                        image: '' ,
                        description: '' ,
                        price: '' ,
                    }
    - Add the constants.js 
            export  const   USERS_PER_PAGE = 10 ;
    - Add to the state the users
            users:{}
    - Add to the mutations.js TWO WAYS 
            ONE WAY
                //debugger;
            /**Response eexist */
            if (response){
        
                state.users = {
                    /**Define the property */
                    data    :   response.data ,
                    links   :   response.meta.links ,
                    total   :   response.meta.total ,
                    limit   :   response.meta.per_page ,
                    from    :   response.meta.from ,
                    to      :   response.meta.to ,
                    page    :   response.meta.current_page ,
                }
            }
            state.products.loading = loading;
            
            SECOND WAY
            //debugger;
            /**Response eexist */
            if (data){
        
                state.users = {
                    ...state.users,
                    /**Define the property */
                    data    :   data.data ,
                    links   :   data.meta?.links ,
                    total   :   data.meta.total ,
                    limit   :   data.meta.per_page ,
                    from    :   data.meta.from ,
                    to      :   data.meta.to ,
                    page    :   data.meta.current_page ,
                }
            }
            state.users.loading = loading;
    - To change getUser in AppLayout into getCurrentUser
    - Go to  actions.js  change getUser to getCurrentUser
    - You can add another getUser in action.js
        add new method getUsers(){}
            moddification perPage = 10  to per_page
    - Change on Sidebar  and the users link onn the dashboard
    - To change the field in the UserssTables.
                            
