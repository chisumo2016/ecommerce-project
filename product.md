### IMPLEMENT PRODUCT CRUD  IN LARAVEL API
    We need to do couple of preparations.
    Install spite laravel slaggable packages
        composer require spatie/laravel-sluggable
    Add into Product Model the trait
    Generate Product Factory and Product Seeder
         php artisan make:seeder ProductSeeder  
         php artisan make:factory  ProductFactory   
    Call the product Factory into Product Seeder
    Open Database seed and call all  seeders
    RUN:  
        php artisan migrate:fresh --seed    

    Implement the CRUD via controller for api
        php artisan make:controller  ProductController --api --requests --model=Product   
    Generate the resources
         php artisan make:resource ProductResource 
         php artisan make:resource ProductListResource 
    What iss the purpose of resource ? 
        Is the layer btn the controoller and actual response which returns to the browser
    Implement the logic fisrt in ProductResource and ProductListResource 
    Implement the Login in ProductController
        - query on index
        -  write all the logic 
    Add the product api route in api file


#### CREATE VUEJS SPINNER COMPONENTS,
    make some tweets in backend folder, inn AppLayout.vue, 
    To make the components for spinner .
            backend/src/components/core/Spinner.vue
    Add the component in the AppLayout.vue file
    Create a file called state.js wiithin store and call it iin index.js


### CREATE PRODUCTS TABLE IN VUEJS
    Open the product file views   backend/src/views/Product.vue
    Go state.js in store folder define the prodducts object
    Then go to products.vue conti... next

### CONNECT PRODUCTS TABLE VUE.JS COMPONENT TO API
    Definne the properties and method  in the prooduct.vue
        const perPage = ref(10);
        const  search   = ref('');
        const  products = computed(() => store.state.products);
    Add the onMounted(() =>{})
    Define the function/method getProducts , will call store actions 
        store.dispatch('getProducts')   is the actions
    onMounted will call getProducts
   
    whenever this getProducts get eexecuuted will call the products in state.js
    Products has been uused in the template.
        const  products = computed(() => store.state.products);
     Define the  function getProducts in actions.js
    Define the mutations  state in mutations.js setProducts()
    Create a constants.js file , import into Product.vue file
        export  const  PRODUCTS_PER_PAGE = 10 ;
        const    perPage   = ref(10);

###  IMPLEMENT PAGINATION
    Add the div below  the end of table tag
    Will be display when the total is greater than product limit
    Showing from {{ products.from }} to {{ products.to }} ,products coming from state.js
    We dont have from , to a, total and limit from product , in the backend we can see
        meta:{
            current_page: 1
            from: 1
            last_page
        links:[{url: null}]
        path: "http:........"
        per_page:10
        to: 10
        total:30
    After nav has been completed , 
    Open the state.js
    Open the mutation.js and defines  in setProducts()

            export  function  setProducts(state , [loading , response = {})  //data or response  response ={}
                    {
                    
                        state.products.loading = loading;
                        state.products.data    = response.data

                    }

           After

            export  function  setProducts(state , [loading , response = null])  //data or response  response ={}
                {
                //debugger;
                /**Response eexist */
                if (response){
                
                        state.products = {
                            /**Define the property */
                            data    :   response.meta.data ,
                            links   :   response.meta.links ,
                        }
                    }
                    state.products.loading = loading;
                
                }
    Create the getForPage() function , will fetch the data for current page.
    GetProduct wiill accept url
    In actions.js we should accept the payload
        before   return  axiosClient.get('product')
        after   return  axiosClient.get(url)

### IMPLEMENT PER PAGE AND SEARCH IN PRODUCTS
    we have already have perPage and search in Products.vue file
    Passs the search and perPage into getProduct() inn product.vue
    We need to take that and pass into actions.js  in getProducts() method.
    Pass into the request  
              return  axiosClient.get(url, {
                    /**Object*/
                    params: { search , perPage: perPage}
                 }
    Open the backend on of the laravel of ProduuctController in index() method.
















