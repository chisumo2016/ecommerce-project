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

/**PRODUCTS SECTION***/
export  function  getProducts({commit} , { url = null, search = '', perPage = 10 , sort_field, sort_direction} ={})
{
    /**Commit Mutations*/
    commit('setProducts',[true])

    url = url || '/products';

    return  axiosClient.get(url, {
        /**Object*/
        params: {
            search ,
            per_page: perPage,
            sort_field,
            sort_direction
        }
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

export  function  getProduct({} , id)
{
    return axiosClient.get(`/products/${id}`)
}

export  function  createProduct({ commit} , product)
{
    if (product.image instanceof File){
        const form = new FormData();
        form.append('title',         product.title);
        form.append('image',        product.image);
        form.append('description',  product.description);
        form.append('price',        product.price);
        product = form;
    }
    return axiosClient.post('/products', product)
}

export  function  updateProduct({ commit} , product)
{
    const id = product.id;
    if (product.image instanceof  File){
        const  form = new FormData();
        form.append('id', product.id);
        form.append('title', product.title);
        form.append('image', product.image);
        form.append('description', product.description);
        form.append('price', product.price);
        form.append('_method', 'PUT');
        product = form;

    }else {
        product._method = 'PUT'
    }

    return axiosClient.post(`/products/${id}`, product)
}

export  function  deleteProduct({ commit}, id) {
    return axiosClient.delete(`/products/${id}`)
}

/** ORDERS SECTION ***/
export  function  getOrders({commit,state} , { url = null, search = '', per_page = 10 , sort_field, sort_direction} ={})
{
    /**Commit Mutations*/
    commit('setOrders',[true])

    url = url || '/orders';

    const params = {
         per_page :  state.orders.limit,
    }

    return  axiosClient.get(url, {
        /**Object*/
        params: {
            ...params,
            search, per_page, sort_field,sort_direction
        }
    })
        .then(response => {
            //debugger;
            /**Commit Mutations*/
            commit('setOrders',[false, response.data])
        })
        .catch(() =>{
            /**Commit Mutations*/
            commit('setOrders',[false])
        })
}

export  function  getOrder({} , id)
{
    //debugger;
    return axiosClient.get(`/orders/${id}`)
}

