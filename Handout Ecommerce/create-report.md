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
## CREATE REPORT TAB COMPONENTS
## APPLY STYLES TO ACTIVE REPORT TAB
## CREATE REUSABLE TRAIT
## CREATE BACKEND API ENDPOINTS TO GET ORDERS DATA
## PROCESS ORDERS DATA FOR CHARTS
## CREATE CUSTOMERS REPORTS
## IMPLEMENT DATE RANGE PICKER IN REPORTS 
## CREATE REPORT
