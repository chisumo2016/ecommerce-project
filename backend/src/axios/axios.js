import axios from "axios";
import store from "../store";
import router from "../router";
import config from "tailwindcss/defaultConfig";

/**Create axios Client*/
const  axiosClient = axios.create({
 /**Backend Laravel Url*/
 baseURL : `${import.meta.env.VITE_API_BASE_URL}/api`
});

axiosClient.interceptors.request.use(config =>{
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    return config;
});

axiosClient.interceptors.response.use(response => {  // fullied or reject - promise
    return response
}, error => {
    if (error.response.status == 401){
        store.commit('setToken',null)
        /**remove the token from session*/
        //sessionStorage.removeItem('TOKEN') //create thee  sessionStorage
        router.push({name : 'login'})
    }
    throw error
   // console.error(error); //throw error
})

export  default  axiosClient;


