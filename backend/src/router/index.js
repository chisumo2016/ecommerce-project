import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";

/**Define an array of routes*/
const  routes = [
    {
        path: '/dashboard',
        name:'dashboard',
        component:Dashboard
    },
    {
        path: '/login',
        name:'login',
        component:Login
    }
    ,
    {
        path: '/password-request',
        name:'PasswordRequest',
        component: RequestPassword
    }
    ,
    {
        path: '/reset-password/:token',  ///reset-password/:token
        name:'ResetPassword',
        component: ResetPassword
    }
];


const  router = createRouter({
    /**Specify Object*/
    history: createWebHistory(), //domain.com/users not domain.com#/users
    routes
});

export  default  router;
