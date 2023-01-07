<template>
    <h1 class="text-4xl mb-3">Dashboard</h1>
   <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <!-- Active Customers-->
       <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center bg-blue-100">
           <label>Active Customers</label>
           <template v-if="!loading.customersCount">
               <span class="text-3xl font-semibold">{{ customersCount }}</span>
           </template>
            <Spinner v-else text="" class="py-2"/>
       </div>
       <!--/ Active Customers-->
       <!-- Active Products-->
       <div class="bg-white py-6  px-5 rounded-lg shadow flex flex-col items-center justify-center">
           <label>Active Products</label>
           <template v-if="!loading.productsCount">
               <span class="text-3xl font-semibold">{{ productsCount }}</span>
           </template>
           <Spinner v-else text="" class="py-2"/>
       </div>
       <!--/ Active Products-->
       <!-- Paid Orders-->
       <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
           <label>Paid Orders</label>
           <template v-if="!loading.paidOrders">
               <span class="text-3xl font-semibold">{{ paidOrders }}</span>
           </template>
           <Spinner v-else text="" class="py-2"/>
       </div>
       <!--/ Paid Orders-->
       <!-- Total Income-->
       <div class="bg-white py-6  px-5 rounded-lg shadow flex flex-col items-center">
           <label>Total Incomes</label>
           <template v-if="!loading.totalIncome">
               <span class="text-3xl font-semibold">{{ totalIncome}}</span>
           </template>
           <Spinner v-else text="" class="py-2"/>
       </div>
       <!--/ Total Income-->
   </div>
        <!--Second Row     -->
    <div class="grid grid-rows-2 grid-flow-col  grid-cols-1 md:grid-cols-3 gap-3">
        <div class="cols-span-2 row-span-2 bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            Products
        </div>
        <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            <label>Orders by Country</label>
            <template v-if="!loading.ordersByCountry">
                <DoughnutChart :width="140" :height="200" :data="ordersByCountry"/>
            </template>
            <Spinner v-else text="" class=""/>
        </div>
        <div class=" bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            Customers
        </div>
    </div>
</template>

<script setup>
import DoughnutChart from '../components/core/Charts/Doughnut.vue'
import axiosClient from "../axios/axios.js";
import { ref} from  "vue";
import Spinner from "../components/core/Spinner.vue";

/**loading indicator*/
const  loading = ref({
    /**Keys*/
    customersCount: true,
    productsCount: true,
    paidOrders: true,
    totalIncome: true,
    ordersByCountry: true,
})
const customersCount    = ref(0);
const productsCount     = ref(0);
const paidOrders        = ref(0);
const totalIncome       = ref(0);
const ordersByCountry = ref({});

axiosClient.get(`/dashboard/customers-count`).then(({ data }) => {
    //debugger;
    customersCount.value = data;
    loading.value.customersCount = false;
})
axiosClient.get(`/dashboard/products-count`).then(({ data }) => {
    productsCount.value = data;
    loading.value.productsCount = false;
})
axiosClient.get(`/dashboard/orders-count`).then(({ data }) => {
    paidOrders.value = data;
    loading.value.paidOrders = false;
})
axiosClient.get(`/dashboard/income-amount`).then(({ data }) => {
    totalIncome.value = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' })
        .format(data);
    loading.value.totalIncome = false;
})

axiosClient.get(`/dashboard/orders-by-country`).then(({ data: countries}) => {
    loading.value.ordersByCountry = false;
    const chartData = {
        labels: [],
        datasets:[{
             /**Push Single Object*/
             backgroundColor: ['#41B883', '#E46651', '#00D8FF', '#DD1B16'],
            data:[]
        }]
    }

    /**Iterate*/
    countries.forEach(c =>{
        /**Push Single Set*/
        chartData.labels.push(c.name);
        chartData.datasets[0].data.push(c.count)
    })
    ordersByCountry.value = chartData;
})


</script>

<style scoped>

</style>
