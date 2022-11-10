import {createStore} from "vuex";

const  store = createStore({
    /**Specify Object*/

    state:{
        user:{
            token: 123,
            data:{}
        }
    },
    getters:{},
    actions:{},
    mutations:{},
});

export  default  store;

