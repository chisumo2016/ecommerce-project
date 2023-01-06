<template>

    <!-- Header   -->
<div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">customers</h1>
</div>
<!--    <pre>{{showModal}}</pre>-->
    <customerModal
        v-model="showModal"
        :customer="customerModel"
        @close="onModalClose">

    </customerModal>
    <!-- Card   -->
    <CustomersTable @clickEdit="editCustomer" />
</template>

<script setup>
import CustomersTable from "./CustomersTable.vue";
import CustomerModal from "./CustomerModal.vue";
import {computed, ref} from "vue";
import store from "../../store";

const DEFAULT_CUSTOMER= { }/**Default Customer is for creating a new customer */

/**Define the property*/
const customers = computed(() => store.state.customers)

const  showModal = ref(false);

const  customerModel = ref({...DEFAULT_CUSTOMER }) //DESTRUCTURE

/**Define the methods*/
const showCustomerModal = () => {
    showModal.value = true
}

const editCustomer = (customer) => {
    store.dispatch('getCustomer', customer.id) //id is from CustomerResource
        .then(({ data }) => {
            /**take data and assign to the customer value*/
            customerModel.value =  data  //take data and assign to the model
            showCustomerModal() //showAddNewModal()
        })
}

// const editCustomer = (customer) => {
//    customerModel.value = customer  //take response and assign to the model
//    showCustomerModal() //showAddNewModal()
// }

/**clear*/
const onModalClose = () => {
    customerModel.value = {...DEFAULT_CUSTOMER}
}
</script>

