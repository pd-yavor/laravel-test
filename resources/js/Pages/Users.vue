<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from "sweetalert2";
import {ref} from "vue";
const props = defineProps({
    users: {
        type: Object,
    }
});
const confirmPopup = (id,type) => {
    Swal.fire({
        title: 'Are you sure?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes!'
    }).then((result) => {
        const user = props.users.find((item) => item.id === id)
        let currentValue;
        if(type === 'login'){
            currentValue = !user.login_access
        }else if(type === 'purchase'){
            currentValue = !user.purchase_access
        }
        if (result.isConfirmed) {
            let text;
            if(type === 'login'){
                text = 'Login';
                user.login_access = currentValue
            }else if(type === 'purchase'){
                text = 'Purchase';
                user.purchase_access = currentValue
            }

            axios.post('/api/user/toggleAccess', {
                id: id,
                type: type
            }).then((response) => {
                if (response.data.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: currentValue ?
                            text+' access was granted successfully!'
                            : text+' access was cancelled successfully!'
                    });

                }else{
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong!',
                    });
                }
            });
        }
    })
}
</script>

<template>
    <Head title="Users" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-between items-center bg-white overflow-hidden px-4 mb-4 py-2 shadow-sm sm:rounded-lg"
                     v-for="user in users" :key="user.id">
                    <div>
                        <p>Name: {{user['name']}}</p>
                        <p>Email: {{user['email']}}</p>
                    </div>
                    <div class="flex flex-col gap-4">
                        <div class="flex justify-between items-center" @click="confirmPopup(user['id'], 'login')">
                            <div class="relative w-11 h-6 flex items-center bg-gray-300 rounded-full duration-300 ease-in-out" :class="{ 'bg-blue-500': user['login_access']}">
                                <div class="absolute left-[4px] bg-white w-5 h-5 rounded-full shadow-md transform duration-300 ease-in-out" :class="{ 'translate-x-4': user['login_access'],}"></div>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Login access</span>
                        </div>
                        <div class="flex justify-between items-center" @click="confirmPopup(user['id'], 'purchase')">
                            <div class="relative w-11 h-6 flex items-center bg-gray-300 rounded-full duration-300 ease-in-out" :class="{ 'bg-blue-500': user['purchase_access']}">
                                <div class="absolute left-[4px] bg-white w-5 h-5 rounded-full shadow-md transform duration-300 ease-in-out" :class="{ 'translate-x-4': user['purchase_access'],}"></div>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-900 dark:text-gray-300">Purchase access</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
