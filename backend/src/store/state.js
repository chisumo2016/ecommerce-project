const state = {
    /**Declare Objects **/
    user: {
       // token: sessionStorage.getItem('TOKEN'),
        data:{}
    },

    products:{
        loading: false,
        data:[],

        links:[],
        from: null,
        to:null,
        page:1,
        limit: null,
        total: null
    },

    orders:{
        loading: false,
        data:[],

        links:[],
        from: null,
        to:null,
        page:1,
        limit: null,
        total: null
    },

    toast: {
        show: false,
        message: '',
        delay: 5000
    },

    users:{
        loading: false,
        data:[],

        links:[],
        from: null,
        to:null,
        page:1,
        limit: null,
        total: null
    },

    customers:{
        loading: false,
        data:[],

        links:[],
        from: null,
        to:null,
        page:1,
        limit: null,
        total: null
    },

    countries: [],
};

export  default  state;
