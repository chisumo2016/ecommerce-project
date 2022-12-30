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
        
        
