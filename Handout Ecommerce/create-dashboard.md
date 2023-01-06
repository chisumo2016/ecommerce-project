#### CREATE DASHBOARD

## CREATE OVERALL INFORMATION CARDS
    - Dashboard 
    - First row
-----------------------------
    1. Number of Active Customers
    1. Number of Active Products
    1. Number of Paid orders
    1. Total    Income

    1. Orders by country(charts)
    2. 5 Top Selling Products
    3. Newly registered customers

    - To start we need to create a dashboard controller
        php artisan make:controller Api/DashboardController  
    - Two approach on working on dashboard
            To return all the data at once,we gonna see single loader
            To load each part independently 
    - We gonna use the second options , implement these methods in Dashboard Controller
                 1. Number of Active Customers
                 1. Number of Active Products
                 1. Number of Paid orders
                 1. Total    Income
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
    - Add the const ordersByCountry on Dashboard.vue file
    - You have to make a request viao axiosClient   and apply the join
    - Apply to Doughnut.vue , pass the data Object
    - convert tthe data ,which contain name and country in axiosClient.get(`/dashboard/orders-by-country`).then(({ data: countries}) => {

### IMPLEMENT LOADING LATEST 5 CUSTOMERS 
### DISPLAYING LATEST 10 ORDERS
### CREATE CURRENCY FORMATTING FILTER
### CHANGE CUSTOMER MODAL INTO PAGE AND LINK FROM DASHBOARD
### ADD ANIMATION TO DASHBOARD  CARDS
### IMPLEMENT DATE PERIOD CHANGE
### UPDATE REPORT DATA BY CHOSEN DATE








        
