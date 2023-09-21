<script setup>
import { defineProps } from 'vue';
const emit = defineEmits(['openPaymentPopup']);
defineProps({
    product: {
        type: Object,
    },
    category: {
        type: String,
    },
});
const openPaymentPopup = (value) => {
    emit('openPaymentPopup', value);
};
</script>
<template>
    <a href="#" class="group">
        <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
            <img :src="product['image']" :alt="product['name']" class="h-full w-full object-cover object-center group-hover:opacity-75">
        </div>
        <div class="mt-4 flex justify-between items-center">
            <h3 class=" text-sm text-gray-700">{{product['name']}}</h3>
            <span>{{category}}</span>
        </div>
        <div class="mt-1 flex justify-between items-center">
            <p class="text-lg font-medium text-gray-900">$ {{product['price']}}</p>
            <button @click="openPaymentPopup(product)" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                Checkout
            </button>
        </div>

    </a>
</template>
