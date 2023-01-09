import {createRouter, createWebHistory} from "vue-router";

import AppLayout from "../components/AppLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Product from "../views/Products/Product.vue";

import NotFound from "../views/NotFound.vue";
import store from "../store";
import Orders from "../views/Orders/Orders.vue";
import OrderShow from "../views/Orders/OrderShow.vue";

import Users from "../views/Users/Users.vue";
import Customers from "../views/Customers/Customers.vue";
import CustomerShow from "../views/Customers/CustomerShow.vue";
import Report from "../views/Reports/Report.vue";
import OrdersReports from "../views/Reports/OrdersReports.vue";
import CustomersReport from "../views/Reports/CustomersReport.vue";

/**Define an array of routes*/
const  routes = [
    /**Define parent root**/
    {
        path: '/app',
        name: 'app',
        redirect: '/app/dashboard',
        component: AppLayout,
        meta:{
            requiresAuth:true
        },
        children:[
            {
                path: 'dashboard',
                name:'app.dashboard',
                component:Dashboard
            },
            {
                path: 'products',
                name:'app.products',
                component:Product
            },
            {
                path: 'orders',
                name:'app.orders',
                component:Orders
            },
            {
                path: 'orders/:id',
                name:'app.orders.show',
                component:OrderShow
            },
            {
                path: 'users',
                name:'app.users',
                component:Users
            },
            {
                path: 'customers',
                name:'app.customers',
                component:Customers
            },
            {
                path: 'customers/:id',
                name:'app.customers.show',
                component:CustomerShow
            },

            /**Define parent Report root**/
            {
                path: '/report',
                name: 'reports',
                component: Report,
                meta:{
                    requiresAuth:true
                },
                /**Define children Report**/
                children: [
                    {
                        path: 'orders',
                        name:'reports.orders',
                        component:OrdersReports
                    },

                    {
                        path: 'customers',
                        name:'reports.customers',
                        component:CustomersReport
                    },
                ]
            },
        ]
    },


    {
        path: '/login',
        name:'login',
        meta:{
            requiresGuest:true
        },
        component:Login
    }
    ,
    {
        path: '/password-request',
        name:'PasswordRequest',
        meta:{
            requiresGuest:true
        },
        component: RequestPassword
    }
    ,
    {
        path: '/reset-password/:token',  ///reset-password/:token
        name:'ResetPassword',
        meta:{
            requiresGuest:true
        },
        component: ResetPassword
    }
    ,
    {
        path: '/:pathMatch(.*)',
        name:'notFound',
        component: NotFound
    }
];


const  router = createRouter({
    /**Specify Object*/
    history: createWebHistory(), //domain.com/users not domain.com#/users
    routes
});

/**HANDLE UNAUTHORIZED USERS TO REDIRECT TO LOGIN PAGE. */
router.beforeEach((to, from, next ) =>{
    if (to.meta.requiresAuth && !store.state.user.token) {

        /** Call next */
      next({name: 'login'});
    }else if (to.meta.requiresGuest &&  store.state.user.token){

             /**Call next*/
        next({ name: 'app.dashboard'});
    }else{
        next();
    }
});

export  default  router;
