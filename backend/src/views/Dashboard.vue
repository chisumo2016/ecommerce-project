<template>
    <h1 class="text-4xl mb-3">Dashboard</h1>
   <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
        <!-- Active Customers-->
       <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
           <label>Active Customers</label>
           <span class="text-3xl font-semibold">15</span>

       </div>
       <!--/ Active Customers-->
       <!-- Active Products-->
       <div class="bg-white py-6  px-5 rounded-lg shadow flex flex-col items-center justify-center">
           <label>Active Products</label>
           <span class="text-3xl font-semibold">30</span>

       </div>
       <!--/ Active Products-->
       <!-- Paid Orders-->
       <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
           <label>Paid Orders</label>
           <span class="text-3xl font-semibold">15</span>

       </div>
       <!--/ Paid Orders-->
       <!-- Total Income-->
       <div class="bg-white py-6  px-5 rounded-lg shadow flex flex-col items-center">
           <label>Total Incomes</label>
           <span class="text-3xl font-semibold">$15000</span>

       </div>
       <!--/ Total Income-->
   </div>
    <div class="grid grid-rows2 grid-flow-col  grid-cols-1 md:grid-cols-3 gap-3">
        <div class="cols-span-2 row-span-2 bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            Products
        </div>
        <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            <DoughnutChart :width="140" :height="200"/>
        </div>
        <div class=" bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center justify-center">
            Customers
        </div>
    </div>
</template>

<script setup>
import DoughnutChart from '../components/core/Charts/Doughnut.vue'

</script>

<style scoped>

</style>
