<template>
    <LineChart :data="chartData" :height="300"/>
</template>

<script setup>
import axiosClient from "../../axios/axios";
import LineChart from "../../components/core/Charts/Line.vue";
import {ref} from "vue";

const chartData = ref([])

axiosClient.get('report/customers')
    .then(({data }) =>{
        chartData.value = data;
    })
</script>

<style scoped>

</style>
