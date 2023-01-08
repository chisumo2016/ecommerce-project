#### CREATE DASHBOARD

## CREATE OVERALL INFORMATION CARDS
    - Dashboard 
    - First row
-----------------------------
    <!--One Row     -->
    1. Number of Active Customers
    1. Number of Active Products
    1. Number of Paid orders
    1. Total    Income

    <!--Second Row     -->
    1. Orders by country(charts)
    2. 5 Top Selling Products
    3. Newly registered customers
    
    - Gonna write complex query
    - To start we need to create a dashboard controller
        php artisan make:controller Api/DashboardController  
    - Two approach on working on dashboard
            To return all the data at once,we gonna see single loader
            To load each individual  part independently 
    - We gonna use the second options , implement these methods in Dashboard Controller
                 1. Number of Active Customers
                        activeCustomers()
                 1. Number of Active Products
                        activeProducts()
                 1. Number of Paid orders
                        paidOrders()
                 1. Total    Income
                        totalIncome()
    - Open an api route file , defines all routes
    - Open the Dashboard.vue file,  design Cards using Tailwindcss style ,

### INSTALL VUE-CHARTS AND CREATE DOUGHNUT CHART
    - We need to output orders by country, we gonna use pie charts library
            https://vue-chartjs.org/
        INSTALLATION
            Go to backennd
                npm i vue-chartjs chart.js
            Create a folder in backend/src/components/core/Charts/Doughnuts.vue

### CREATE PRODUCTS AND CUSTOMERS EMPTY CARDS
    - Create a  second row 
    - Create an empty cards for products and customers.

### LOAD DATA FROM BACKEND FOR DASHBOARD SUMMARY CARDS
    - Declare all for const ref 
    - Declare / make axiosCliennt request to the server
        axiosClient.get(`/dashboard/customers-count`).then(({ data }) => customersCount.value = data)
        axiosClient.get(`/dashboard/products-count`).then(({ data }) => productsCount.value = data)
        axiosClient.get(`/dashboard/orders-count`).then(({ data }) => paidOrders.value = data)
        axiosClient.get(`/dashboard/income-amount`).then(({ data }) => totalIncome.value = data)
    - Loading indicator  loading and commennt the text in the spinner.vvue
    - Apply loading to each service  and axiosClient

### FORMAT NUMBER AS CURRENCY
    - Number format javascript 
        https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/NumberFormat
    - Put into totalIncome

### GET ORDERS BY COUNTRY AND LOAD INTO DOUGHNUT CHART
    - Add the ordersByCountry method in DashboardCController
    - Write few join table in OrdersByCountry
    - Add the api route
    - Add the const ordersByCountry on Dashboard.vue file annd group them by country
    - Order belongs to Customer
    - Customer has a address
    - Join to users table
    - Take user to be customer_id 
    - Join Order to a Customer , then to customer address and group by country
    - a is alias for customer_addresses
    - You have to make a request viao axiosClient   and apply the join
    - Apply to Doughnut.vue , pass the data Object, we have a data which contains an array
        contains name and country
    - convert tthe data ,which contain name and country in axiosClient.get(`/dashboard/orders-by-country`).then(({ data: countries}) => {
        Finish all logic in the 

    ERROR:
            Vue warn]: Missing required prop: "data" at <Doughnut chartData=


### IMPLEMENT LOADING LATEST 5 CUSTOMERS 
    - Create a new  function called latestCustomers in dashboard controller
    - create a api route for latest customers
    - Call the latest customers in Dashboard.vue
            const latestcustomers 
            make a call to axiosClient
            set  latestCustomers
            add join users
            whenever the user confirm the email address . let sset the status to be active
            Open the app/Http/Controllers/Auth/VerifyEmailController.php
                    $customer = $request->user()->customer;
                    $customer->status = CustomerStatus::Active->value;
                    $customer->save();
            change div to router link
    Add the loading 



### DISPLAYING LATEST 10 ORDERS
    - Create a new  function called latestOrders in dashboard controller
    - create a api route for latest latestOrders
    - Call the latest customers in Dashboard.vue
            const latestOrders 
            make a call to axiosClient
            set  latestOrders
            add join users
            change div to router link
    - Cteate a dashboard resource
            php artisan make:resource Dashboard/OrderResource  
    - Add the Orderresource in the  latestOrders
        
### CREATE CURRENCY FORMATTING FILTER
    - Filter the  for currency
    - Implement the pipe , create a filters folder  backend/src/filters/currency.js
                    export default function currencyUSD(value) {
                    return new Intl.NumberFormat('en-US', {style: 'currency', currency: 'USD'})
                    .format(value);
                    }
    - Add filters in main.js
            app.config.globalProperties.$filters = {
            currencyUSD
        }
    - Import currency.js
        import currencyUSD from './filters/currency.js'

### CHANGE CUSTOMER MODAL INTO PAGE AND LINK FROM DASHBOARD
    - Update the modal  on this section.
    - create a new router called app.customers.view
         {
                path: 'customers/:id',
                name:'app.customers.show',
                component:CustomerShow
         },
    - Copy OrderShow.vue into Customers folder and call CustomerShow 
        Cut the form from the customerModal and paste into CustomerShow.vue
        Take the logic of title fromm customerModal and Paste into CustomerShow.vue in <h1></h1>
             {{ customer.id ? `Update customer: "${props.customer.first_name} ${props.customer.last_name}"` : 'Create new Customer' }}
        To change the props into customer
            {{ customer.id ? `Update customer: "${customer.first_name} ${customer.last_name}"` : 'Create new Customer' }}
    - Take the loading indicator from CustomerMModal and Paste into CustomerShow
        const loading = ref(false)

            const customer = ref({ //we don't pass field as we're updating a .Two way binding
            billingAddress: {},
            shippingAddress: {}
            })

            const countries = computed(() => store.state.countries.map(c =>({ key: c.code, text: c.name})));

            /**Billing country_code*/
            const billingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.billingAddress.country_code));
            
            /**State Billing Option */
            const billingStateOptions = computed(() => {
            if (!billingCountry.value || !billingCountry.value.states) return [];
            
                /**Object of an array of array*/
                return Object.entries(billingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
            });
            
            /**Shipping country_code*/
            const shippingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.shippingAddress.country_code));
            const shippingStateOptions = computed(() => {
            if (!shippingCountry.value || !shippingCountry.value.states) return [];
            
                /**Object of an array of array*/
                return Object.entries(shippingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
            });




const onSubmit = () => {
loading.value = true

    if (customer.value.id){
        console.log(customer.value.status )
        customer.value.status = !!customer.value.status //convert into boolean
        store.dispatch('updateCustomer', customer.value)
        .then(response => {
            loading.value = false;
            if (response.status === 200){
                /**Show Notification*/
                store.dispatch('getCustomers')
                closeModal()
            }
        })
    }else{
        store.dispatch('createCustomer', customer.value)
        .then(response =>{
            loading.value  = false;
            if (response.status === 201){
                /**Show Notification*/
                store.dispatch('getCustomers')
                closeModal()
            }
        })
        .catch(error =>{
            loading.value = false;
            //debugger;
        })
    }
    }
    - Remove the following code from CustomerModal


                const props = defineProps({
                modelValue: Boolean,
                
                    /**Object*/
                    customer:{
                        required: true,
                        type:Object
                    }
                })
            const emit = defineEmits(['update:modelValue'])

                const  show = computed({
                get: () => props.modelValue,
                set: (value) => emit('update:modelValue', value, 'close')
                })

            onUpdated(() =>{
                customer.value = {
                    id: props.customer.id,
                    first_name: props.customer.first_name,
                    last_name: props.customer.last_name,
                    email: props.customer.email,
                    phone: props.customer.phone,
                    status: props.customer.status,
            
                    /**Billing & shipping from CustomerResource*/
                    billingAddress:{
                        ...props.customer.billingAddress
                    },
                    shippingAddress:{
                        ...props.customer.shippingAddress
                    }
                }
                    })
                    
                    function closeModal() {
                    show.value = false
                    emit('close')
                    }

    - Instead of closeModal() , redirect to the page ,customer list
        const router = useRouter
    - Open router.js file and the link
            {
                path: 'customers/:id',
                name:'app.customers.show',
                component:CustomerShow
            },
    - Open dashboard  and add   <router-link :to="{name: 'app.customers.show', params:{id: c.id}}"

    ERROR:
        TypeError: Cannot read properties of undefinned (reading 'states')

    SOLUTION: Delete teh CustomerModal
    
    - Open the CustomersTable  change the edit <button to bee router link and remove 
            @click="editCustomer(customer)"
        remover 
        // const editCustomer = (customer) => {
        //     emit('clickEdit', customer)
        // }
    - add animate-fade-in-down" in customerShow.vue
### ADD ANIMATION TO DASHBOARD  CARDS
    - add animation to all four animate-fade-in-down"  in dashboard
        style="animation-delay: 0.2s"
### IMPLEMENT DATE PERIOD CHANGE
    - Add the dropdown next to the dashboard title.using select
            <select name="" id="">
                <option value="">Last Day</option>
                <option value="">Last Week</option>
                <option value="">Last Month</option>
                <option value="">Last 3 Month</option>
                <option value="">Last 3 Month </option>
            </select>
    - Whenever we choose this ,we gonna update the dashboard.
    - Change tthe @change in the CustomInput to be onChange abd call the function on it
                function onChange(value) {
                    emit('update:modelValue', value)
                    emit('change', value)
                }
    - All the request goes to updateDashboard() in Dasboard.vue
    - Loading value should changed innto ttrue
    - add const  d = chosenDate.value
    - pass the d in all request {params: { d }}
    - use it in DashboardConntroller on index

### UPDATE REPORT DATA BY CHOSEN DATE
    - Add the private function called getFromDate in api/DashbaordController
    - call to both function in DashboardCController










        
