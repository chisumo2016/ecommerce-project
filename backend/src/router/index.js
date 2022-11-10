import {createRouter, createWebHistory} from "vue-router";

import AppLayout from "../components/AppLayout.vue";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import Product from "../views/Product.vue";
import NotFound from "../views/NotFound.vue";
import store from "../store";

/**Define an array of routes*/
const  routes = [
    /**Define parent root**/
    {
        path: '/app',
        name: 'app',
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
    if (to.meta.requiresAuth && !store.state.user.token){
        /** Call next */
      next({name:'login'});
    }else if (to.meta.requiresGuest &&  store.state.user.token){

             /**Call next*/
        next({ name: 'app.dashboard'});
    }else{
        next();
    }
});

export  default  router;
