#### OUTPUT ALL ORDERS INN VUE.JS ADMIN PANEL
    Working in admin side ,using vue.js
    Display all customers order in sngle place.
    Navigate to backend of vue.js in our apllication.
    http://localhost:5175/login  This is vue.js server
            admin@test.com
            password123
    Add the menu in router/index.js
        {
                path: 'orders',
                name:'app.orders',
                component:Orders
            },
    Create a views Component Orders  file   
            backend/src/views/Orders/Orders.vue
    
    Copy everything from Products vue and paste, we dont need modal
         - No need of add new order Button ,remove
         - We need orders Table 
         - Remove Modal
         - We need a click event called @clickShow , display individual Order
         - We can remove DEFAULT_EMPTY_OBJECT  as we dont have modal
         - we should get the orders fromm the state
                const orders = computed(() => store.state.orders)
         - Go in the states    backend/src/store/state.js
                orders:{
                    loading: false,
                    data:[],
            
                    links:[],
                    from: null,
                    to:null,
                    page:1,
                    limit: null,
                    total: null
                }
         - Create a Orderstable.vue , taking the one in the ProductsTable and duplicate.
                - Open the ordersTable.vue  , find all getProducts and replace with getOrders
                - Start from the Top to Down
                - Open the ordersTable.vue  , find all products in lower case and replace with orders in lower case
                - Open the ordersTable.vue  , find all Product in Upper case and replace with Order in upper case
                - We need to remove some fews things
                - Open sidebar and duplicate and name Order





    NB REMEMBER TO UPDATE IN PRODUCTTABLEE
                || !products.data.length

                <tr>
                        <td colspan="6">
                            <spinner v-if="orders.loading" class="my-4"></spinner>
                            
                            <p v-else class="text-center py-8 text-gray-700">There are no products </p>
                        </td>
                    </tr>
                Add this inns sorting @click="sortorder('number_of_items')" 
### LOAD DATA INTO ORDERS TABLE
    Open the actions.js 
            change  commit('setProducts',[true])  to commit('setOrders',[true])
            change  url = url || '/products';     to url = url || '/orders';

            const params = {
                 per_page :  state.orders.limit,
            }

            return  axiosClient.get(url, {
        /**Object*/
                params: {
                    search ,
                    per_page: perPage,
                    sort_field,
                    sort_direction
                }
            })  
          TO

        return  axiosClient.get(url, {
        /**Object*/
        params: {
        ...params,
        search, per_page, sort_field,sort_direction
        }
        })

    commit('setOrders',[false, response.data])
    Open the mutation.js / methods and add the method setOrders
    To create a OrderController
            php artisan make:controller  Api/OrderController
            Copy the index from ProductController and passte into OrderController
            Make few changes as it Order Model nopt Product Model
            Make OrderListResource
                    php artisan make:resource OrderListResource
            Add the relationship onn Order Model called user()
            Add the relationship onn Order Model called customer()
                    order belongsto user
                    order belongsto customer
            NOTE : Will be access via user in UserResource .No customer()
    Open api file route 
            add two routes , index() and show()
    On index mmethod two logic can work
                $query = Order::query()
                    ->where(  'id',        'like', "%{$search}%")
                    ->orderBy($sortField, $sortDirection)
                    ->paginate($perPage);
                return  OrderListResource::collection($query->paginate($query);
    Display customer information
    Return id, first_name, last_name inn UserCustomerListResource
            

#### PREPARE API FOR ORDERS DETAILS PAGE
    Create a OrderResource 
        php artisan make:resource OrderResource
    Implement the vue 
            - Remove all the menu in OrdersTable.vue
            -Add the button with eye icon from heroiicons
                    <router-link :to="{{ }}"></router-linkrouter-link>
            - add tthe router link in router.js
                    {
                        path: 'orders/:id',
                        name:'app.orders.show',
                        component:OrderShow
                    },
            - Create a OrderShow component, make a reequest to get a cuurrent order
            -create an actions getOrder for single order
            - Use the dispatch in OrderShow in OrderShow.vue file, to take an id  vue-router()
                            const route = useRouter();
                                    onMounted(() =>{
                                        //debugger;
                                        store.dispatch('getOrder', route.params.id)
                                    })
            - Link <router-link :to="{name: 'app.orders.show', params:{id: order.id} }"
    Open the backend of OrderController and add show(){}
    Disable OrderResource with $wrap
            public static $wrap = false;
    We need much mmore information than this ,information out the address,when admmin click on 
        hhe order will see all the information .
            - Create a UserCustomerResource
                    php artisan make:resource UserCustomerResource
            - In order for this to work 'addresses'  => $this->customer->addresses
                    'shippingAddress'  => $this->customer->shippingAddress,
                    'BillingAddress'  => $this->customer->billingAddress
            - In the OrderResource ,we're using UserCustomerResource, return everything
    

### CREATE FINAL VERSION OF ORDER RESOURCE
        Here we're going to modify some few things.
        Create a new resourcee for CustomerAddressRessource app/Http/Resources/CustomerAddressResource.php
        Relationship to be defined in CustomerAddress and County Models
        Add the relationship in the CustomerAddressResourcee
        Adjust some few changes in UserCutsomerResource 
             'shippingAddress'  => $this->customer->shippingAddress,
             'shippingAddress'  => new CustomerAddressResource($this->customer->shippingAddress),
             'BillingAddress'  => $this->customer->billingAddress
             'BillingAddress'  =>  new CustomerAddressResource($this->customer->billingAddress),
        We need to return the order Items, open OrderResource , create an OrderItemResource
        Delete UserCustomerListResource.php
        Some few modification
            'BillingAddress'  =>  new CustomerAddressResource($this->customer->billingAddress),
        Delete the app/Http/Resources/CustomerAddressResource.php
        Delete the app/Http/Resources/OrderItemResource.php
        Delete the app/Http/Resources/UserCustomerResource.php
        Change the 'number_of_items'   => $this->items()->count(), into 'items'   => $this->items()->count(),
              This item will an arrays or [] inn OrderResource
        view the full code in OrderResource , will help us to display single page in vueee


### CREATE ORDER DETAILS PAGE OR INNER PAGE 
    Create an UI iin show page vue in backend.
    We need to dispay the order Details
    Add the const order = ref({});
    Add this on Mountented
            .then(({data}) =>{
                //debugger;
                order.value = data
            })
    To implement the logic in  Actions and Mutation.js
    To implement the logic in Order Controller in show method
    Add the route in api .
    We need to display Order Details
    We need to display Customer Details
    We need to display Billing  and Shipping Address Details UI
    We need to display Order Item
    Put a lodder 
        <template>
            <div v-if="order">
            </div>
        </template>
    

       Error:
       {message: "Attempt to read property "first_name" on null", exception: "ErrorException",…}
       exception
        
        Problem: Data information was missing in the database .Was not caused with  code.

            
    
    














            
          
