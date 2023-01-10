### CREATE REPORT

## ADD PUBLISHED COLUMN TO PRODUCT TABLE
    - Add a new column in product migratioon call published
        php artisan make:migration add_published_column_to_products
        php artisan migrate
    - Open products migration
        $table->boolean('published')->default(false);
    - Open productModal below 
            add into local property  published : props. product.published,
            add into onUpdated published : props. product.published,
    - add the CustomInput checkbox
    - open the productRequest add the published field
    - open the productResoouurce  and return the published 
    - open the product model and add published mass assisgmentt
    - open the api product controller , when we save the product
    - oopen the front end c productt controlelr 
        add where clause where('published', '=', 1)
    - Open thd dashbooard controller add addd the logic for activeProduct

    NB: Search int formater javascript no decimal
            add into dashboard.vue minimumFractionDigits


## CREATE REPORT ROUTES IN VUEJS
    Reports
    ----------------
        1:Number of orders per day 
             we gonna use bar charts
        2: Nummber of new customers per pay
             we gonna use line charts

    - Create folder called  Reports
        backend/src/views/Reports/CustomersReport.vue
        backend/src/views/Reports/OrdersReport.vue
        backend/src/views/Reports/Report.vue
    - Will be a container of nested routes
            Report.vue
                <router link>Orders Reposrt</router-link>
                <router link>Customers Report</router-link>
                <router view />
    - Define all routes in index.js 
            report parent
                ordersReport children
                customersReport children
           add redirect: '/app/dashboard',
    - Add the route-link in side bar

    
## CREATE REPORT TAB COMPONENTS
    - give the name routes in Reports.vue in router link
        eg <router-link to="{name: 'reports.orders}" >Orders Report</router-link>
    - Let put router view in some div
    - Give some styles to the router links

## APPLY STYLES TO ACTIVE REPORT TAB
    - Add the active link to the router link
        eg active-class="text-indigo-600 bg-indigo-50"
    - Take it and assign to cusstomer report router link
    - give some css onn the router-view
        
## CREATE REUSABLE TRAIT
    -  Where we gonna return the report for customer or orders report from backend side.
    - Create a ReportController
        php artisan make:controller ReportController 
    - Create two functions
        orders() 
            select for specific period
        orders() 
            select for specific period
    - Create traits folder in app of root project and call ReportTrait.php
    - Call the Traits in the dashboardController , dashboard is like reporting page.Especially wee want to display something by date
             use ReportTrait;
    - Take the getFromDate()  from Dashboard a put into traits.

    - Use the same traits in Report Controller
            use ReportTrait


## CREATE BACKEND API ENDPOINTS TO GET ORDERS DATA
    - Write a logic in the ReportController on orders() function
    - Add the api routes  and add two routes for orders and customers
    - Open the OrderReport.vue file and add setup
        Use axiosClient.get() to get the data from the server
    - Create a components called Bar.vue
    - Call in OrdersReportt.vue

        ERROR:
            Failed to reload in backend/src/views/Reports/OrdersReports.vue .
            Typerror:Cannot destructure property 'default' of 'undefined' as it is undefined.
        SOLUTION:
            Remove the plugin and PropType

        ERROR: Uncought (in promise) referencesError: data is not defined at proxy  Bar.vue

        SOLUTION: 
            Inside the Bar.vue we gonna access the data chartData: data, TO chartData: props.data,

        
    
## PROCESS ORDERS DATA FOR CHARTS
    - Display report per day 
            x-axis days  -labelss
            y-axis no of orders
    - Tale the orders and grouped by days
    - SQL
        SELECT CAST(created_at AS DATE) as day, count(id) FROM orders
        GROUP BY 
    - Add all logic into OrderController
    - add api route
## CREATE CUSTOMERS REPORTS
    - Copy bar and paste - called Line.vue
    - Copy OrdersReport.vue and paste - CustomersReport.vue
        Add the axiosClient.get()
    - Go to ReportController 
        logic in the customers() function
            $fromDate = $this->getFromDate() ?: Carbon::now()->subDay(30);
        $query = Customer::query()
            ->select([DB::raw('CAST(created_at as DATE) AS day'), DB::raw('COUNT(user_id) AS count')])
            ->groupBy(DB::raw('CAST(created_at as DATE)'));
        if($fromDate){
            $query->where('created_at','>' , $fromDate);
        }

        /**Order will be an associative array*/
        $orders = $query->get()->keyBy('day');;

        /**Process for chartjs*/
        $days = [];
        $labels = [];
        $now = Carbon::now();
        while ($fromDate < $now) {
            $label = $fromDate->format('Y-m-d');
            $labels[] = $label;
            $fromDate = $fromDate->addDay(1);
            $days[] =  isset($orders[$label]) ? $orders[$label]['count'] : 0;
        }

        return [
            'labels' => $labels,
            'datasets' => [[
                'label'=> 'Customers By Day',
                'backgroundColor' => '#f87979',
                'data' => $days
            ]]
        ];

    - Put on separate method  as private prepareDataForBarChart(){}
## IMPLEMENT DATE RANGE PICKER IN REPORTS 
    - Put a date range dropdown in Report.vue file
    - Open report.vue and put two router link in a div and another below router view for select
    - Take the select snipet code fromm Dashboard.vue , however we donnt have the choseDate , OnDatePickerChange and dateOption
    - We need to specify the useRouter , useRoute  
    - Open the router/index.js and add  the params date in both orders and customers
            eg.   {
                        path: 'orders',
                        name:'reports.orders',
                        component:OrdersReports
                    },
    - dateOptions is loooks as code duplicated , to move into state
        const dateOptions  = ref([
                {key: '2d' , text: 'Last Day'},
                {key: '1w' , text: 'Last Week'},
                {key: '2w' , text: 'Last 2 Week'},
                {key: '1m' , text: 'Last Month'},
                {key: '3m' , text: 'Last 3 Month'},
                {key: '6m' , text: 'Last 6 Month'},
                {key: 'all' , text: 'All Time'},
            
            ])
        To 
        const dateOptions  = computed(() => store.state.dateOptions); See on state

    ERRR:
        Missing required param "data" at object.stringify
    SOLUTION:
        Go in the router/index.js and make params optional
                    {
                        path: 'orders:date?',
                        name:'reports.orders',
                        component:OrdersReports
                    },
    - Add the  current routte in OrdersReport.vue
            const route = useRoute();
        Watch the current route params

            watch(route.params, (rt)=>{
                console.log(rt.params.date)
            }, {deep:true})

            watch(route, (rt)=>{
                console.log(rt.params.date)
            })

    - create a getData and pass the request ,and call getData() inside the watch()
    - We have to do the similar to customersReport.vue.


## CREATE REPORT
