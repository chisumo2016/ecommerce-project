<template>
    <div class="min-h-full bg-gray-200 flex">
        <!-- Sidebar-->
            <SideBar :class="{'-ml-[200px]' : !sidebarOpened}"></SideBar>
        <!--/ Sidebar-->

        <div class="flex-1">
            <TopHeader @toggle-sidebar="toggleSidebar"></TopHeader>

            <main class="p-6">
               <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import SideBar from "./SideBar.vue";
import TopHeader from "./TopHeader.vue";
import {ref} from "vue";

/**Build In defineProps*/
const { title }= defineProps({
    title: String
});

/**Properties*/
const sidebarOpened = ref(true);

/**Listen ToggleSidebar*/
const toggleSidebar = () => {
    sidebarOpened .value = !sidebarOpened.value
  console.log('works')
}
</script>

<style scoped>

</style>
