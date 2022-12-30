#### CUSTOMER CRUD INN VUE.JS ADMIN PANEL
    We're using an API to pull the data .
### CREATE CUSTOMER TABLE COMPONENT 
    - Display menu items, simmilar to users , will be accomplished by opening the sidebar menu item backend
    - Open the router and add app.customers link
    - Add heroicons for Customers 
    - Take the users folder folder and duplicate.Call Customers  annd renamme
                CustomerModal.vue
                Customers.vue
                CustomersTable.vue
    - Click Arror up + cmd + R   find User and Replace Customer
    - Click Arror up + cmd + R   find user and Replace customer
    - Click Arror up + cmd + R   find USER and Replace CUSTOMER

    - Open the actions.js file 
            add all CRUD for customers
    - Opeen the Mutations.js file 
            add SetCustomers()
    - Finally open state.jss file
        add customer:{}
    - Add the CUSTOMERS_PER_PAGE in constant files

    - Make sure you link and import the Customers components in backend/src/router/index.js
    - Add some fields in the CustomersTable files
            Remember the email comes from user table.
            Show some address information
            No point to create a customer on admin side. We should remove the Add New Customer Button
    - Open the Customer Modal file and change the names fields based on database.

### PREPARE LARAVEL API CONTROLLER  FOR CUSTOMER (API/CUSTOMERCONTROLLER)
    - Create a customer controller , we can duplicate the product controller
            php artisan make:controller Api/CustomerController -r --model=customer  
    - Create a  request for Customer
            php artisan make:request CustomerRequest   
            Use the profile request validation 
            https://laravel.com/docs/9.x/validation#rule-enum
    - Staatus filled will have some enums option, we need to create enum file CustommerStatus.php
            Pending - before the emmail has approved
            Active  - 
            Disabled - Admin may decide to disbled
    - Create a customer List resource file
            php artisan make:resource CustomerListResource   (DISPLAY ALL INFORMATION )
    - Create a customer resource file (WHAT INFORMATION ARE WE GOING TO RETURN FROM HERE )
            php artisan make:resource CustomerResource  
             Copy the information from OrderResource shipping and billing
             email -> user relation
    - Implement all the logic for Customer CRUD inn the CustomerController
            We don't have customer recreation through an API. Remove store()
    - Add tthe route customers in route file api

    - TEST OUR APPLICATION: NOT PASSED
    - TEST OUR APPLICATION: PASSED


###  CREATE CUSTOMER EDIT FORM WITH ADDRESS
    - Open the customerTable view and adjust some fields
    - Status is empty by the way.
    - CLICK edit button , the request was nt made to the saver .So openn users.vue file
        ERROR: AxiosError AND  http://ecommerce-project.test/api/customers/undefined 404 (Not Found)
            SOLUTION: We're return tthe user_id as ID IN CustomerResource
    - Render the customer address in CustomerModal (billingAddress and shippingAddress)
    - We need to pass both billingAddress and shippingAddress on the onUpdate(() =>{})
         - we need to destructure the billingAddress and shippingAddress

### UPDATE CUSTOMER INPUT COMPONENT ADD CHECKBOX
    - We need to change the status field into checkbox, for that we need to add the checkbox in the CustomInput.vue file
            <template v-else-if></>
    - Generate the id number on CustomInput file
    
     
        
