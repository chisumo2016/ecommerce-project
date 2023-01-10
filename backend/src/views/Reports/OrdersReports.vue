<template>
  <BarChart :data="chartData" :height="240"/>
</template>

<script setup>
import axiosClient from "../../axios/axios";
import BarChart from "../../components/core/Charts/Bar.vue";
import {ref, watch} from "vue";
import {useRoute} from "vue-router";



const route = useRoute();
const chartData = ref([])

/**watch */
watch(route, (rt)=>{
    getData()
   // console.log(rt.params.date)
}, { immediate: true})


function  getData(){
axiosClient.get('report/orders', { params: { d: route.params.date}})
    .then(({data }) =>{
        chartData.value = data;
    })
}
</script>

<style scoped>

</style>
