/**Import axios client */
import axiosClient from "../axios/axios";

/**Define function login**/
export  function login({commit}, data) { //data - user data
    return axiosClient.post('/login',data)
        .then(({data} ) => {
            /**Commit the user data save in store state, done using mutation*/
            commit('setUser',data.user); //current setUser
            commit('setToken',data.token);

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
