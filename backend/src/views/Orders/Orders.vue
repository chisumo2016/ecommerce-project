<template>

    <!-- Header   -->
    <div class="flex items-center justify-between mb-3">
        <h1 class="text-3xl font-semibold">Orders</h1>
    </div>

    <!-- Card   -->
    <OrdersTable @clickShow="showOrder" />
</template>

<script setup>
import OrdersTable from "./OrdersTable.vue"
import store from "../../store";
import {computed} from "vue";

const orders = computed(() => store.state.orders);


const showOrder = (order) => {

}
</script>

<style scoped>

</style>
