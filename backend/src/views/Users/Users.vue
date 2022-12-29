<template>

    <!-- Header   -->
<div class="flex items-center justify-between mb-3">
    <h1 class="text-3xl font-semibold">users</h1>
    <button type="submit"
            @click="showUserModal"
            class=" flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600
             hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Add New user
    </button>
</div>
<!--    <pre>{{showModal}}</pre>-->
    <userModal
        v-model="showModal"
        :user="userModel"
        @close="onModalClose">

    </userModal>
    <!-- Card   -->
    <UsersTable @clickEdit="editUser" />
</template>

<script setup>
import UsersTable from "./UsersTable.vue";
import UserModal from "./UserModal.vue";
import {computed, ref} from "vue";
import store from "../../store";

const DEFAULT_USER = {
    id: '' ,
    title: '' ,
    image: '' ,
    description: '' ,
    price: '' ,
}

/**Define the property*/
const users = computed(() => store.state.users)

const  showModal = ref(false);

const  userModel = ref({...DEFAULT_USER }) //DESTRUCTURE

/**Define the methods*/
const showUserModal = () => {
    showModal.value = true
}

const editUser = (user) => {
   userModel.value = user  //take response and assign to the model
   showUserModal() //showAddNewModal()
}

/**clear*/
const onModalClose = () => {
    userModel.value = {...DEFAULT_USER}
}
</script>

