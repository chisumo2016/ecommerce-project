<template>
    <div class="min-h-full flex">
        <!-- Sidebar-->
            <SideBar></SideBar>
        <!--/ Sidebar-->

        <div class="flex-1">
            <header class="h-8 shadow bg-white">
                Header
            </header>
            <main>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import SideBar from "./SideBar.vue";

/**Build In defineProps*/
const { title }= defineProps({
    title: String
});


</script>

<style scoped>

</style>
