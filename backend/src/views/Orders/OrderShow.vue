<template>

</template>

<script setup>
import store from "../../store";
import {onMounted} from "vue";
import {useRoute} from "vue-router";

const route = useRoute();

onMounted(() => {
    //debugger;
    store.dispatch('getOrder', route.params.id)
})
</script>

<style scoped>

</style>
