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
