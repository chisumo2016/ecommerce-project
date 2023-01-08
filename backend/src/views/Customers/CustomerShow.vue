<template>

    <div v-if="customer.id" class="animate-fade-in-down">

        <form @submit.prevent="onSubmit">

            <div class="bg-white px-4 pt-5 pb-4">
                <h1 class="text-2xl font-semibold  pb-2 "> {{ title }}</h1>
                <CustomInput
                    class="mb-2"
                    v-model="customer.first_name"
                    label="First Name"/>

                <CustomInput
                    class="mb-2"
                    v-model="customer.last_name"
                    label="Last Name"/>

                <CustomInput
                    class="mb-2"
                    v-model="customer.email"
                    label="Email"/>

                <CustomInput
                    type="password"
                    class="mb-2"
                    v-model="customer.phone"
                    label="phone"/>

                <CustomInput
                    type="checkbox"
                    class="mb-2"
                    v-model="customer.status"
                    label="Active"/>

                <!--  Billing Address  -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Billing Address</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <CustomInput    v-model="customer.billingAddress.address1" label="Address 1"/>
                            <CustomInput    v-model="customer.billingAddress.address2" label="Address 2"/>
                            <CustomInput    v-model="customer.billingAddress.city" label="City"/>
                            <CustomInput    v-model="customer.billingAddress.zipcode" label="Zip Code"/>


                            <CustomInput  type="select" :select-options="countries"  v-model="customer.billingAddress.country_code" label="country_code"/>
                            <CustomInput   v-if="!billingCountry.states" v-model="customer.billingAddress.state" label="State"/>
                            <CustomInput  v-else type="select" :select-options="billingStateOptions"  v-model="customer.billingAddress.state" label="State"/>
                        </div>
                    </div>


                    <!--  Shipping  Address  -->
                    <div>
                        <h2 class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300">Shipping Address</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            <CustomInput    v-model="customer.shippingAddress.address1" label="Address 1"/>
                            <CustomInput    v-model="customer.shippingAddress.address2" label="Address 2"/>
                            <CustomInput    v-model="customer.shippingAddress.city" label="City"/>
                            <CustomInput    v-model="customer.shippingAddress.zipcode" label="Zip Code"/>


                            <CustomInput  type="select" :select-options="countries"  v-model="customer.shippingAddress.country_code" label="country_code"/>
                            <CustomInput   v-if="!shippingCountry.states" v-model="customer.shippingAddress.state" label="State"/>
                            <CustomInput  v-else type="select" :select-options="shippingStateOptions"  v-model="customer.shippingAddress.state" label="State"/>

                        </div>
                    </div>

                </div>

            </div>
            <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="submit"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm
                                        text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                    Submit
                </button>
                <router-link :to="{ name: 'app.customers'}" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                         ref="cancelButtonRef">
                    Cancel
                </router-link>
            </footer>
        </form>

    </div>
</template>

<script setup>
import store from "../../store";
import {computed, onMounted, ref} from "vue";
import {useRoute, useRouter} from "vue-router";
import  CustomInput from "../../components/core/CustomInput.vue";


const router = useRouter();
const route  = useRoute();
const  title = ref('')

/** Define local property */
const loading = ref(false)



const customer = ref({ //we don't pass field as we're updating a .Two way binding
    billingAddress: {},
    shippingAddress: {}
})


onMounted(() => {
    //debugger;
    store.dispatch('getCustomer', route.params.id)
    .then(({data}) => {
        //debugger;
        title.value = `Update customer: "${data.first_name} ${data.last_name}" `
        customer.value = data
    })

})

const countries = computed(() => store.state.countries.map(c =>({ key: c.code, text: c.name})));

/**Billing country_code*/
const billingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.billingAddress.country_code));

/**State Billing Option */
const billingStateOptions = computed(() => {
    if (!billingCountry.value || !billingCountry.value.states) return [];

    /**Object of an array of array*/
    return Object.entries(billingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
});

/**Shipping country_code*/
const shippingCountry = computed(() => store.state.countries.find(c =>  c.code === customer.value.shippingAddress.country_code));
const shippingStateOptions = computed(() => {
    if (!shippingCountry.value || !shippingCountry.value.states) return [];

    /**Object of an array of array*/
    return Object.entries(shippingCountry.value.states).map(c => ({key: c[0], text: c[1]}))
});


const onSubmit = () => {
    loading.value = true

    if (customer.value.id){
        console.log(customer.value.status )
        customer.value.status = !!customer.value.status //convert into boolean
        store.dispatch('updateCustomer', customer.value)
            .then(response => {
                loading.value = false;
                if (response.status === 200){
                    /**Show Notification*/
                    store.dispatch('getCustomers')
                    router.push({ name: 'app.customers'});
                    //closeModal()
                }
            })
    }else{
        store.dispatch('createCustomer', customer.value)
            .then(response =>{
                loading.value  = false;
                if (response.status === 201){
                    /**Show Notification*/
                    store.dispatch('getCustomers')
                    router.push({ name: 'app.customers'});
                    //closeModal()
                }
            })
            .catch(error =>{
                loading.value = false;
                //debugger;
            })
    }
}
</script>

<style scoped>

</style>
