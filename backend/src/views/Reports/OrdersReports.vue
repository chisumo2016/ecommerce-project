<template>
  <BarChart :data="chartData" :height="300"/>
</template>

<script setup>

import axiosClient from "../../axios/axios";
import BarChart from "../../components/core/Charts/Bar.vue";
import {ref} from "vue";

const chartData = ref([])

axiosClient.get('report/orders')
.then(({data }) =>{
    chartData.value = data
})
</script>

<style scoped>

</style>
