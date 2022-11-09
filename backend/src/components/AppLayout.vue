<template>
    <div class="min-h-full bg-gray-200 flex">
        <!-- Sidebar-->
            <SideBar></SideBar>
        <!--/ Sidebar-->

        <div class="flex-1">
            <TopHeader></TopHeader>
            <main class="p-6">
               <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import SideBar from "./SideBar.vue";
import TopHeader from "./TopHeader.vue";

/**Build In defineProps*/
const { title }= defineProps({
    title: String
});


</script>

<style scoped>

</style>
