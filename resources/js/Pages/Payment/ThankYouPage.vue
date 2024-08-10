<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full text-center">
            <div class="flex items-center justify-center mb-4">
                <div class="bg-purple-500 text-white p-4 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-semibold text-purple-600 mb-2">Thank You!</h1>
            <p class="text-gray-600 mb-6">Your order has been received</p>
            <div class="text-left">
                <div class="mb-4">
                    <p class="text-gray-500">Order number</p>
                    <p class="font-semibold text-gray-700">#{{ orderNumber }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-500">Date</p>
                    <p class="font-semibold text-gray-700">{{ date }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-500">E-mail</p>
                    <p class="font-semibold text-gray-700">{{ email }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-500">Name</p>
                    <p class="font-semibold text-gray-700">{{ name }}</p>
                </div>
                <div class="mb-4">
                    <p class="text-gray-500">Total</p>
                    <p class="font-semibold text-gray-700">${{ total }}</p>
                </div>
                
            </div>
            <div class="mt-6">
                <p class="text-sm text-gray-500 mb-6">
                    We have sent your digital download link and invoice to your email.
                </p>
                <button
                    @click="completeShopping"
                    class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-5 rounded-md w-full transition-colors"
                >
                    Continue Shopping
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const props = defineProps({
    orderNumber: String,
    date: String,
    email: String,
    name: String,
    total: String,
});


const completeShopping = () => {
    // Redirect the user back to the home page or shop page
};
</script>

<style scoped>
</style>
