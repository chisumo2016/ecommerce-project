export function setUser(state, user) {
    state.user.data = user;
}

export  function setToken(state, token) {
    state.user.token = token;
    /**Save in sessionstorage*/
    if (token){
       sessionStorage.setItem('TOKEN', token)
    }else{
        sessionStorage.removeItem('TOKEN')
    }
}

export  function  setProducts(state , [loading , response = null])  //data or response  response ={}
{
    //debugger;
    /**Response eexist */
    if (response){

        state.products = {
            /**Define the property */
            data    :   response.data ,
            links   :   response.meta.links ,
            total   :   response.meta.total ,
            limit   :   response.meta.per_page ,
            from    :   response.meta.from ,
            to      :   response.meta.to ,
            page    :   response.meta.current_page ,
        }
    }
    state.products.loading = loading;

}
