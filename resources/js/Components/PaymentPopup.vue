<script setup>
import { defineProps, defineEmits } from 'vue';
import {loadStripe} from '@stripe/stripe-js';
import {onMounted, ref} from "vue";
import {usePage} from "@inertiajs/vue3";
import axios from "axios";
import Swal from "sweetalert2";

const emit = defineEmits(['processPayment','closePopup']);
const props = defineProps({
    product: {
        type: Object,
    },
});
const paymentProcessing = ref(false);
const page = usePage();
const stripe = ref(null);
const cardRef = ref(null);
const cardElement = ref(null);
const customerName = ref('');
const customerEmail = ref('');
onMounted(async () => {
    stripe.value = await loadStripe(page.props.stripe_key);
    const elements = stripe.value.elements();
    cardElement.value = elements.create('card', {
        classes: {
            base: 'bg-gray-100 border border-gray-300 rounded-md shadow-sm px-3 py-2 mt-1 text-sm w-full',
        },
    });
    cardElement.value.mount(cardRef.value);
})
const  processPayment = async (product) => {
    const {paymentMethod, error} = await stripe.value.createPaymentMethod({
        type: 'card',
        card: cardElement.value,
    });
    if(customerName.value === '' || customerEmail.value === ''){
        error.message = customerName.value === '' ? 'Please enter your name!' : 'Please enter your email!';
    }else if(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(customerEmail.value) === false){
        error.message = 'Please enter a valid email!';
    }
    if (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error ? error.message : 'Please fill all fields!',
        });
    }else{
        paymentProcessing.value = true;

        const customer = {};
        customer.payment_method_id = paymentMethod.id;
        customer.name = customerName.value;
        customer.email = customerEmail.value;
        axios.post('/api/purchase', {
            customer: customer,
            card: product,
        }).then((response) => {
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Payment was successful! You will receive an email with the details of your purchase.',
                });
                paymentProcessing.value = false;
                emit('closePopup');
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.data.message,
                });
                paymentProcessing.value = false;
            }
        })
    }
};
const closePopup = (event) => {
    const isPopupBack = event.target.classList.contains('popupBack');
    if (isPopupBack && !paymentProcessing.value) {
        emit('closePopup');
    }
};
</script>
<template>
    <div tabindex="-1"
         @click="closePopup($event)"
         aria-hidden="true"
         class="popupBack bg-zinc-700/50 fixed top-0 left-0 right-0 z-50 w-full overflow-x-hidden overflow-y-auto md:inset-0 max-h-full">
        <div class="popupBack flex justify-center items-center min-h-screen">

            <form class="h-auto w-2/6 bg-white p-3 rounded-lg">
                <div class="field mb-3">
                    <label for="name">Full name</label>
                    <input class="bg-gray-100 border border-gray-300 rounded-md shadow-sm px-3 py-2  text-sm w-full"
                           v-model="customerName"
                           :disabled="paymentProcessing"
                           type="text" id="name" name="name"
                           required>
                </div>
                <div class="field mb-3">
                    <label for="email">Email</label>
                    <input class="bg-gray-100 border border-gray-300 rounded-md shadow-sm px-3 py-2  text-sm w-full"
                           v-model="customerEmail"
                           :disabled="paymentProcessing"
                           type="email" id="email" name="email" required>
                </div>
                <div ref="cardRef"></div>
                <p class="text-lg text-center mt-4 text-gray-600 font-semibold">Payment amount: $ {{product['price']}}</p>
                <div class="flex justify-center mt-4">
                    <button
                        type="button"
                        :disabled="paymentProcessing"
                        @click="processPayment(product)"
                        v-text="paymentProcessing ? 'Processing...' : 'Pay'"
                        class="outline-none pay h-12 bg-blue-600 text-white mb-3 hover:bg-blue-700 rounded-lg w-1/2 cursor-pointer transition-all"></button> </div>
            </form>
        </div>
    </div>
</template>
