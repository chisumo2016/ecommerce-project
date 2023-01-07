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



### DISPLAYING LATEST 10 ORDERS
### CREATE CURRENCY FORMATTING FILTER
### CHANGE CUSTOMER MODAL INTO PAGE AND LINK FROM DASHBOARD
### ADD ANIMATION TO DASHBOARD  CARDS
### IMPLEMENT DATE PERIOD CHANGE
### UPDATE REPORT DATA BY CHOSEN DATE








        
