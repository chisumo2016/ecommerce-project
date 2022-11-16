import {createStore} from "vuex";
import  * as actions  from './actions';
import  * as mutations  from './mutations';
import  state  from './state.js';

const  store = createStore({
    /**Specify Object*/

    state,
    getters:{},
    actions: actions,
    mutations: mutations,
});

export  default  store;

