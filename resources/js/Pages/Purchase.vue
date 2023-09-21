<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import ProductList from '@/Components/ProductList.vue';
import PaymentPopup from "@/Components/PaymentPopup.vue";
import {loadStripe} from '@stripe/stripe-js';

import {onMounted, ref} from "vue";
defineProps({
    products: {
        type: Object,
    },
    categories: {
        type: Object,
    },
});

const page = usePage();
const stripe = ref(null);
const cardElement = ref(null);
const choosedProduct = ref(null);
const paymentPopupShow = ref(false);
const openPaymentPopup = (value) => {
    paymentPopupShow.value = true;
    choosedProduct.value = value;
};
const closePopup = () => {
    paymentPopupShow.value = false;
};
const processPayment = (product) => {

};

</script>

<template>
    <Head title="Purchase" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class=" overflow-hidden sm:rounded-lg">
                    <ProductList
                        @openPaymentPopup="openPaymentPopup"
                        :products="products"
                        :categories="categories"/>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
    <PaymentPopup
        v-if="paymentPopupShow"
        @processPayment="processPayment"
        @closePopup="closePopup"
        :product="choosedProduct"/>
</template>
