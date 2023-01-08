import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import store from "./store";
import router from "./router";
import currencyUSD from './filters/currency.js'

//import './assets/main.css'


const  app = createApp(App);
  app
    .use(store)
    .use(router)
    .mount('#app');

app.config.globalProperties.$filters = {
    currencyUSD
}
