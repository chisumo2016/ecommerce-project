<template>
    <div v-if="currentUser.id" class="min-h-full bg-gray-200 flex" >

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

    <!--  Loader Spinner -->
    <div v-else class="min-h-full bg-gray-200 flex items-center justify-center">
      <Spinner></Spinner>
    </div>
</template>

<script setup>
import SideBar from "./SideBar.vue";
import {computed, onMounted, onUnmounted, ref} from "vue";
import NavBar from "./NavBar.vue";
import store from "../store";
import Spinner from "./core/Spinner.vue";

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

/**Load current User*/
const  currentUser = computed(() => store.state.user.data);

const handleSidebarOpened  = () => {
    sidebarOpened.value = window.outerWidth > 768
    // if (window.outerWidth < 768 ){
    //     sidebarOpened.value = false
    // }else{
    //     sidebarOpened.value = true
    // }
}

/**onMounted*/
onMounted( () =>{
    store.dispatch('getUser')
    handleSidebarOpened();
    window.addEventListener('resize', handleSidebarOpened)
});
1
/**onUnmounted*/
onUnmounted(() =>{

    window.removeEventListener('resize', handleSidebarOpened)
})


</script>

<style scoped>

</style>
