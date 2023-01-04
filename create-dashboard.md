#### CREATE DASHBOARD

## CREATE OVERALL INFORMATION CARDS
    - Dashboard 
    - First row
-----------------------------
    1. Number of Active Customers
    1. Number of Active Products
    1. Number of Paid orders
    1. Total    Income

    1. Orders by country
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
            
        
