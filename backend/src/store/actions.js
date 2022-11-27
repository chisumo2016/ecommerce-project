/**Import axios client */
import axiosClient from "../axios/axios";

/**Define function login**/
export  function login({commit}, data) { //data - user data
    return axiosClient.post('/login',data)
        .then(({data} ) => {
            /**Commit the user data save in state, done using mutation*/
            commit('setUser',  data.user); //current setUser
            commit('setToken', data.token);

            return data;

        })
}


/**Define function logout**/
export  function logout({commit}) { //data - user data
    return axiosClient.post('/logout')
        .then((response) => {
            commit('setToken',null);

            return response;
        });
}
export  function getUser({ commit}, data)
{
    return axiosClient.get('/user', data)
        .then(({data}) =>{ //object user
            //debugger;
            commit('setUser', data)
            return data;
        })
}

export  function  getProducts({commit} , { url = null, search = '', perPage = 10 })
{
    /**Commit Mutations*/
    commit('setProducts',[true])

    url = url || '/product';

    return  axiosClient.get(url, {
        /**Object*/
        params: { search , per_page: perPage}
     })
        .then(response => {
            //debugger;
   /**Commit Mutations*/
        commit('setProducts',[false, response.data])
   })
    .catch(() =>{
        /**Commit Mutations*/
        commit('setProducts',[false])
    })
}
