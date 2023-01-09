<template>
    <div>
        <div class="grid  gap-3 grid-cols-2">
            <router-link :to="{name: 'reports.orders'}"
                         class="bg-white py-2 px-3 text-gray-700 rounded-md text-center">Orders Report</router-link>
            <router-link :to="{name: 'reports.customers'}"
                         class="bg-white py-2 px-3 text-gray-700 rounded-md text-center">Customers Report</router-link>
        </div>

        <div>
            <router-view />
        </div>
    </div>
</template>

<script>
export default {
    name: "Report"
}
</script>

<style scoped>

</style>
