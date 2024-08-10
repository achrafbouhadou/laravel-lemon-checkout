<template>
    <div class="order-summary">
        <h3 class="text-lg font-medium mb-6">Your Order</h3>
        <div class="space-y-6 mb-8">
            <div class="flex justify-between items-center" v-for="item in items" :key="item.id">
                <img :src="item.image" alt="item.name" class="h-16 w-16 object-cover rounded-md">
                <div>
                    <p class="font-medium">{{ item.name }}</p>
                </div>
                <p class="font-medium">{{ item.price }} USD</p>
            </div>
        </div>

        <div class="space-y-3">
            <div class="flex justify-between font-medium">
                <p>Subtotal</p>
                <p>{{ subtotal }} USD</p>
            </div>
            <div class="flex justify-between font-medium">
                <p>Discount</p>
                <p>{{ discount }} USD</p>
            </div>
            <div class="flex justify-between font-medium text-lg">
                <p>Total</p>
                <p>{{ total }} USD</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

// Define props to accept data from parent component
const props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    subtotal: {
        type: Number,
        required: true,
    },
    shipping: {
        type: Number,
        required: true,
    },
    total: {
        type: Number,
        required: true,
    },
});
</script>

<style scoped>
</style>
