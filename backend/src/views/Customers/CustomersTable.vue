<template>
    <!-- Card   -->
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select @change="getCustomers(null)" v-model="perPage"
                        class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-3">Found {{ customers.total}} customers</span>
            </div>
            <div>
                <input v-model="search"
                       @change="getCustomers(null)"
                       class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                       placeholder="Type to Search Customers">
            </div>
        </div>

<!--        <spinner v-if="Customers.loading" class="my-4"></spinner>-->

            <table class="table-auto w-full">
                <thead>
                <tr>
                    <TableHeaderCell @click="sortCustomers('id')"  class="border-b-2 p-2 text-left" field="id" :sort-field="sortField" :sort-direction="sortDirection">ID</TableHeaderCell>
                    <TableHeaderCell @click="sortCustomers('name')"  class="border-b-2 p-2 text-left" field="name" :sort-field="sortField" :sort-direction="sortDirection">Name</TableHeaderCell>
                    <TableHeaderCell @click="sortCustomers('email')"  class="border-b-2 p-2 text-left" field="email" :sort-field="sortField" :sort-direction="sortDirection">Email</TableHeaderCell>
                    <TableHeaderCell @click="sortCustomers('phone')"  class="border-b-2 p-2 text-left" field="phone" :sort-field="sortField" :sort-direction="sortDirection">Phone</TableHeaderCell>
                    <TableHeaderCell @click="sortCustomers('status')"  class="border-b-2 p-2 text-left" field="status" :sort-field="sortField" :sort-direction="sortDirection">Status</TableHeaderCell>
                    <TableHeaderCell @click="sortCustomers('created_at')"  class="border-b-2 p-2 text-left" field="created_at" :sort-field="sortField" :sort-direction="sortDirection">Register At</TableHeaderCell>
                    <TableHeaderCell field="actions">
                        Actions
                    </TableHeaderCell>
                </tr>
                </thead>
                <tbody v-if="customers.loading.loading || !customers.data.length">
                    <tr>
                        <td colspan="7">
                            <Spinner v-if="customers.loading"></Spinner>
                            <p class="text-center py-8 text-gray-700">There are no customers</p>
                        </td>
                    </tr>
                </tbody>

                <tbody v-else>
                <tr v-for="(customer, index) of customers.data" >
                    <td class="border-b p-2">{{ customer.id }}</td>
                    <td class="border-b p-2">
                        {{ customer.first_name }}   {{ customer.last_name }}
                    </td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden  text-ellipsis">
                        {{ customer.email }}
                    </td>
                    <td class="border-b p-2">{{ customer.phone }}</td>
                    <td class="border-b p-2">{{ customer.status }}</td>
                    <td class="border-b p-2">{{ customer.created_at }}</td>
                    <td class="border-b p-2">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75 ">
                                    <DotsVerticalIcon
                                     class="h-5 w-5 text-indigo-500" aria-hidden="true"/>
                                </MenuButton>
                            </div>
                            <transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            />

                            <MenuItems
                                class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <div class="px-1 py-1">
                                    <MenuItem v-slot="{ active }">
                                        <button
                                               :class="[
                                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                  ]"
                                               @click="editCustomer(customer)"
                                                    >

                                            <PencilIcon
                                                :active="active"
                                                class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true"
                                            />
                                            Edit
                                        </button>
                                    </MenuItem>
                                    <MenuItem v-slot="{ active }">
                                        <button
                                            :class="[
                                                active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                                'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                              ]"
                                            @click="deleteCustomer(customer)"
                                        >
                                            <TrashIcon
                                                :active="active"
                                                class="mr-2 h-5 w-5 text-indigo-400"
                                                aria-hidden="true"
                                            />
                                            Delete
                                        </button>
                                    </MenuItem>
                                </div>

                            </MenuItems>
                        </Menu>
                    </td>
                </tr>
                </tbody>
            </table>

    <!--  Pagination  -->
        <div
            v-if="!customers.loading"
            class="flex justify-between items-center mt-5">
            <div v-if="customers.data.length">
                 Showing from {{ customers.from }} to {{ customers.to }}
            </div>
            <nav
                v-if="customers.total >customers.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                aria-label="Pagination">
            <!-- from backend -->
                <a
                    v-for="(link, i) of customers.links"
                    :key="i"
                    :disabled="!link.url"
                    @click.prevent="getForPage($event, link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                    :class="[
                        link.active
                        ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                       : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === customers.links.length - 1 ? 'rounded-r-md' : '',
                       !link.url ? ' bg-gray-100 text-gray-700': ''
                    ]"
                    v-html="link.label"
                    href="#">

                </a>
            </nav>
        </div>
    </div>
</template>

<script setup>
import Spinner from "../../components/core/Spinner.vue";
import {computed, onMounted, ref} from "vue";
import store from "../../store";
import {CUSTOMERS_PER_PAGE} from "../../constants.js";
import TableHeaderCell from "../../components/core/Table/TableHeaderCell.vue";
import {Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import {DotsVerticalIcon, PencilIcon, TrashIcon} from '@heroicons/vue/outline'


/**Define properties*/
const    perPage   = ref(CUSTOMERS_PER_PAGE );
const    search    = ref('');
const    customers  = computed(() => store.state.customers);
const    sortField = ref('updated_at');
const    sortDirection = ref('desc');

const customer = ref({})
const showCustomerModal = ref(false);

const emit = defineEmits(['clickEdit'])



/**Methods*/
onMounted(() =>{
    getCustomers();
})

function getCustomers(url = null) {
    store.dispatch('getCustomers', { //getCustomers executed and get the Customers
        url ,
        search          : search.value,
        perPage         : perPage.value,
        sort_field      : sortField.value,
        sort_direction  : sortDirection.value

    });
}

const  getForPage = (event , link ) => {
    event.preventDefault();
    if (!link.url || link.active){
        return;
    }
    getCustomers(link.url)
}

const sortCustomers = (field) => {
    if (sortField.value === field){
        if (sortDirection.value === 'asc') {
            sortDirection.value = 'desc'
        }else {
            sortDirection.value = 'asc'
        }
    }else {
        sortField.value = field;
        sortDirection.value = 'asc'
    }
    getCustomers();
}


function showModal() {
    showCustomerModal.value = true
}

const editCustomer = (customer) => {
    //debugger;
    emit('clickEdit', customer)
}

const deleteCustomer = (customer) => {
  if (!confirm(`Are you sure you want to delete the Customer ?`)){
      return
  }
  store.dispatch('deleteCustomer', customer.id)
    .then(response =>{
        /**Show Notification*/
        store.dispatch('getCustomers')
    })
}
</script>

<style scoped>

</style>
