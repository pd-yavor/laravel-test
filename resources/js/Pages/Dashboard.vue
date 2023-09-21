<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import axios from "axios";
import Swal from "sweetalert2";
const props = defineProps({
   orders: {
       type: Array,
       default: () => []
   }
});

const refundRequest = (order) => {
    axios.post('/api/refund', {
        id: order.id
    }).then((response) => {
        if(response.data.status === 'success') {
            Swal.fire({
                title: 'Success',
                text: 'Refund request sent successfully',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
            props.orders.find((item) => item.id === order.id).is_refund_request = true;
        } else {
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }
    }).catch((error) => {
        console.log(error);
    });
}

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h1 class="block font-medium text-lg mb-4">{{$page.props.auth.user.role.name}}</h1>

                <div
                    :class="['flex justify-between items-center bg-white overflow-hidden px-4 mb-4 py-2 shadow-sm sm:rounded-lg', order.is_refund_request ? 'opacity-60' : '']"                     v-for="order in orders" :key="order.id">
                    <ul>
                        <li class="text-sm">Card number: **** **** **** <b>{{order.last_four}}</b></li>
                        <li class="text-sm">Transaction ID: <b> {{order.transaction_id}}</b></li>
                        <li class="text-sm">Product: <b> {{order.product}}</b></li>
                    </ul>
                    <div class="flex items-center gap-4">
                        <p>Status: <span>{{order.status}}</span></p>

                        <button
                            v-if="!order.is_refund_request"
                            @click="refundRequest(order)"
                            class="button px-2 py-3 bg-blue-400 text-white rounded">Request Refund</button>
                        <button v-else-if="order.status !== 'refunded'"
                                class="button px-2 py-3 bg-gray-300 text-white rounded">
                            Request sent
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
