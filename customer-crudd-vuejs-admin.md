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
    - ERROR: id: props.customer.id,

### IMPLEMENT CUSTOMER UPDATE PART 1
    - Testing the submiting the customer
    - id is null , when u click edit , Problem comes fromm CustomerResource.php file
            'id'=> $this->id  to 'id'=> $this->user_id ,
    Inn the CustomerModal file name we need to update 
         {{ customer.id ? `Update Customer: "${props.customer.first_name} ${props.customer.last_name}"
    - Update the CustomerRequest file .
            billing to billingAddress
            shipping to shippingAddress
    - Status is return null insteead of truee, we should return bool
    - On the onSubmit() we should add customer.value.status = !!customer.value.status
    - SSelect status  is invalid , remove the ,new Enum(CustomerStatus::class)
    - We need to retun some country . Create a CountryController
                 php artisan make:controller  Api/CountryController
    - Add the route file
    - We can search customer when the adminn open the application or load the country when we open the cusstomer page.
    - Third approad ,when we click tthe edit modal , the coutntry will load.
    - So open AppLayout.vue file
            Add this  store.dispatch('getCountries') onMMounted
            Add into actions.js  getCountries
            Create a Mutation setCountries
            Add into state.js to be an emty array
    - Take countries in the customer modal add select 
            <seleect></select>
            Loop the countries
            <select v-model="customer.billingAddress.country">  // comes from CustomerResource
                <option v-for="country of countries" :value="country.code">{{ country.name }}</option>
            </select>
           The countries isn't in the template yet , we need to ccreate a computed property
                const countries = computed(() => store.state.countries);
           Test the application ,returninng an eempty array ,type error
            ERROR:
                 Missing required prop: "customer" 
                  CustomerModal.vue:189 Uncaught (in promise) TypeError: Cannot read properties  of undefined (reading 'id') 

### UPDATE CUSTOMER INPUT COMPONENT ADD SELECT SUPPORT
    Add a new input type in CustomerInput.vue called 'select'
        add the selectOptions on the scripts of Customsinput
                selectOptions: Array
        Render it into CustomerModal on select annd map the countries key and text 
                const countries = computed(() => store.state.countries.map(c =>({ key: c.code, text: c.name})));
        Click EEdit button :ERROR
                Cannot read properties of nnull (reading.emitOptions)
        SOLUTION: We dont need v-modeel in CustomInput file in customerInput
    - iN THE CustomerResource file we need to return country->code not name

### IMPLEMENT COUNTRY STATE CASCADING DROPDOWN
    - Copy the selct from billing and put onn shpping
        <CustomInput  type="select" :select-options="countries"  v-model="customer.shippingAddress.country" label="Country"/>
    - Whenever we choose the the counntry we sshould dipslay the dropdown 
    - We need thee country object , computed  const billingCountry
    - Add pre tag on edit {{ billingCountry }}
        ERROR: 
            Cannot read properties of undefined (reading 'counntry') happend in CustomerModal : line 134:106
        SOLN :
            On the mount the customer billing address doent exist
                const customer = ref({
                         billingAddress: {}
                         shippingAddress: {}
                })

    - const customer = ref({ }) we use for two way binding

    - Showing the errors of EmitOptionss
        ERROR:
            const billingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.billingAddress.country));
        SOLN:
            Add the .value
            const billingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.billingAddress.country));

    - Create CountryResource
            php artisan make:resource CountryResource      
            Return the fields
    - In the CountryController wee need to return the  resource
    - Connvert sttriing into object by using json_decode
    - Intterate these object
    - Test edit 
            store.state.countries.find is nnot a function
        SOLUTTION:
          Got into mutations.js in setContries()  pass .data
    - Render  v-if inn state and write the computed stateOptions
    -Test Application 
        Cannt copnvert undefined or null to object
        SOLUTIN
            To put into if () on computed stateOptions -CustomerModal

    - To update the CustomerRequest
            'billingAddress.country_code'       => ['required' ,'exists:countries,code'], TO
            'billingAddress.country'            => ['required' ,'exists:countries,code'],

    - Test Application  ERROR
        undefined array key \"shipping"
        SOLN:
        CustmerController ->update(){}
                $shippingData = $CustomerData['shipping']; TO
                $shippingData = $CustomerData['shippingAddress']; TO
                $billingData  = $CustomerData['billing']; TO
                $billingData  = $CustomerData['billingAddress'];

    - To modify 
        const billingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.billingAddress.country));
        const shippingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.billingAddress.country));
        const billingStateOptions = computed(() => {
        if (!billingCountry.value || !billingCountry.value.states) return [];
        
            /**Obkect of an array of array*/
            Object.entries(billingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
        });
        
        const shippingStateOptions = computed(() => {
        if (!shippingCountry.value || !shippingCountry.value.states) return [];
        
            /**Obkect of an array of array*/
            Object.entries(shippingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
        });

    - Test : Error
        Cannot read properties of undefined (reading 'states')
        SOLN
            Change country to country_code in CustomerModal
            In the customer Request  change to  'billingAddress.country_code'  
            In the CustomerResource file change 'country_code' 

### IMPLEMENT  CUSTOMER UPDATE PART 2
    - Define the status of the customer in the dtabase.
    - Let us go to the  api of CustomerController in update(){}
             $CustomerData['status'] = $CustomerData['status'] ? CustomerStatus::Active->value : CustomerStatus::Disabled->value;
    - Again let us look on CustomerModal.vue, look on onSubmit function
        degguer
        Let change on CustomerResource ,we need to change
             'status'        => $this->status, TO
             'status'        => $this->status === CustomerStatus::Active->value, 
        Go CustomerInput file 
         @emit instead of @cchange
            @emit="emit('update:modelValue',   $event.target.value)"
            @change="emit('update:modelValue', $event.target.checked)"

### IMPLEMENT CUSTOMER SEARCH , BY NAME , EMAIL , PHONE
    - To implement search , CustomerController -> index()
             Change
            $query = Customer::query()
                ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), 'like', "%{$search}%")
                ->join('users', 'customers.user_id', '=', 'users.id')
                ->orderBy($sortField, $sortDirection)
                ->paginate($perPage);

### DEBUGGING LARAVEL ERROR
### RESTRICT DISABLED CUSTOMER LOGIN
    - Customer who is disabled , should not logged in .
    - Go to app/Http/Controllers/Auth/AuthenticatedSessionController.php
            open \App\Http\Requests\Auth\LoginRequest
    - ERROR
        Undefined property : Illuminate\Auth\AuthManager::$customer
        SOLN:
              $user = $this->user();

    ERROR:  Missing required prop: "customer" 

    
            

        
        





    
    
    

    
     
        
