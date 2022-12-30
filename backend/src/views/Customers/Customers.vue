<template>

    <!-- Header   -->
<div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">Customers</h1>
    <button type="submit"
            @click="showCustomerModal"
            class=" flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600
             hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Add New Customer
    </button>
</div>
<!--    <pre>{{showModal}}</pre>-->
    <CustomerModal
        v-model="showModal"
        :Customer="CustomerModel"
        @close="onModalClose">

    </CustomerModal>
    <!-- Card   -->
    <CustomersTable @clickEdit="editCustomer" />
</template>

<script setup>
import CustomersTable from "./CustomersTable.vue";
import CustomerModal from "./CustomerModal.vue";
import {computed, ref} from "vue";
import store from "../../store";

const DEFAULT_Customer = {
    id: '' ,
    title: '' ,
    image: '' ,
    description: '' ,
    price: '' ,
}

/**Define the property*/
const Customers = computed(() => store.state.customers)

const  showModal = ref(false);

const  CustomerModel = ref({...DEFAULT_Customer }) //DESTRUCTURE

/**Define the methods*/
const showCustomerModal = () => {
    showModal.value = true
}

const editCustomer = (Customer) => {
   CustomerModel.value = Customer  //take response and assign to the model
   showCustomerModal() //showAddNewModal()
}

/**clear*/
const onModalClose = () => {
    CustomerModel.value = {...DEFAULT_Customer}
}
</script>

