import { createApp } from 'vue'
import App from './App.vue'
import './index.css'
import store from "./store";

import './assets/main.css'

createApp(App)
    .use(store)
    .mount('#app')
