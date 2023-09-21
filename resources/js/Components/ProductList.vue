<script setup>
import ProductCard from '@/Components/ProductCard.vue';
const emit = defineEmits(['openPaymentPopup']);
const props = defineProps({
    products: {
        type: Object,
    },
    categories: {
        type: Object,
    },
});

const openPaymentPopup = (value) => {
    emit('openPaymentPopup', value);
};
const productCategoryName = (category_id) => {
   return props.categories.find(category => category.id === category_id).name;
};
</script>
<template>
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 sm:py-8 lg:max-w-7xl lg:px-8">
        <h2 class="sr-only">Products</h2>
        <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 xl:gap-x-8">
            <ProductCard
                v-for="product in products"
                @openPaymentPopup="openPaymentPopup"
                :key="product.id"
                :product="product"
                :category="productCategoryName(product.category_id)"/>
        </div>
    </div>

</template>
