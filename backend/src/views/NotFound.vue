<template>
    <div class="flex justify-center items-center min-h-full w-full min-w-full">
        <div class="flex">
            <div class="text-indigo-500   self-start text-5xl  p-8 font-bold border-r pb-8 leading-10">404</div>
            <div class="px-8 ">
                <h1 class="text-5xl font-bold mb-2">Page not found</h1>
                <p class="text-gray-400 mb-10">Please check the url in address bar annd try again</p>
                <div>
                    <router-link :to="{name : 'app.dashboard'}"
                        class="justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-500">
                        Go back home
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>

</style>
