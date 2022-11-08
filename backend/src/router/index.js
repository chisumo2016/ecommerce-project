import {createRouter, createWebHistory} from "vue-router";
import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";

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
];


const  router = createRouter({
    /**Specify Object*/
    history: createWebHistory(), //domain.com/users not domain.com#/users
    routes
});

export  default  router;
