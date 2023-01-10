

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

    dateOptions:[
            {key: '2d' , text: 'Last Day'},
            {key: '1w' , text: 'Last Week'},
            {key: '2w' , text: 'Last 2 Week'},
            {key: '1m' , text: 'Last Month'},
            {key: '3m' , text: 'Last 3 Month'},
            {key: '6m' , text: 'Last 6 Month'},
            {key: 'all' , text: 'All Time'},

        ]
};

export  default  state;
