<template>
    <div class="min-h-full bg-gray-200 flex">
        <!-- Sidebar-->
            <SideBar :class="{'-ml-[200px]' : !sidebarOpened}"></SideBar>
        <!--/ Sidebar-->

        <div class="flex-1">
            <NavBar @toggle-sidebar="toggleSidebar"></NavBar>\

            <main class="p-6">
               <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
import SideBar from "./SideBar.vue";
import {onMounted, onUnmounted, ref} from "vue";
import NavBar from "./NavBar.vue";

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

/**onMounted*/
onMounted( () =>{
    handleSidebarOpened();
    window.addEventListener('resize', handleSidebarOpened)
});

/**onUnmounted*/
onUnmounted(() =>{
    window.removeEventListener('resize', handleSidebarOpened)
})

const handleSidebarOpened  = () => {
    sidebarOpened.value = window.outerWidth > 768
    // if (window.outerWidth < 768 ){
    //     sidebarOpened.value = false
    // }else{
    //     sidebarOpened.value = true
    // }
}
</script>

<style scoped>

</style>
