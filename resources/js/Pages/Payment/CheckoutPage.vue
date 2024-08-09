<template>
    <div class="bg-gray-50 flex justify-center py-10">
        <div class="bg-white w-full max-w-5xl shadow-lg rounded-lg p-10 flex">
            <!-- Left Section - Shipping and Payment Details -->
            <div class="w-2/3 pr-8">
                <h2 class="text-2xl font-semibold mb-6">Checkout</h2>

               

                <div class="mb-10">
                    <h3 class="text-lg font-medium mb-3">Payment Details</h3>
                    <form @submit.prevent="handleSubmit">
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium">
                                Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" v-model="form.name" placeholder="ex:John Doe" required>
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full p-3 border border-gray-300 rounded-md" v-model="form.email" placeholder="ex:Z5rJt@example.com" required>
                        </div>

                        <div class="mb-4">
                            <label for="whatsapp" class="block text-sm font-medium">
                                WhatsApp Number
                            </label>
                            <div class="relative mt-1">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <img src="@assets/images/whatsapp_icon.png" alt="WhatsApp" class="h-5 w-5">
                                </span>
                                <input type="text" id="whatsapp" name="whatsapp" class="block w-full pl-10 p-3 border border-gray-300 rounded-md" v-model="form.whatsapp" placeholder="ex:+1 123 456 7890">
                            </div>
                        </div>

                        <!--  Payment Method Selector -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium mb-3">Payment Method</h3>
                            <div class="flex space-x-4">
                                <div
                                    v-for="method in paymentMethods"
                                    :key="method.id"
                                    @click="selectPaymentMethod(method.id)"
                                    :class="['flex-1 p-4 border rounded-lg flex flex-col items-center cursor-pointer', { 'border-teal-500 bg-teal-50': form.payment_method === method.id }]"
                                >
                                    <img :src="method.image" alt="method.name" class="h-16 mb-2">
                                    <p>{{ method.name }}</p>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-5 rounded-md w-full">Purchase 537,00 USD</button>
                    </form>
                </div>
            </div>

            <!-- Right Section - Order Summary -->
            <div class="w-1/3">
                <h3 class="text-lg font-medium mb-6">Your Order</h3>
                <div class="space-y-6 mb-8">
                    <div class="flex justify-between items-center" v-for="item in orderItems" :key="item.id">
                        <img :src="item.image" alt="item.name" class="h-16 w-16 object-cover rounded-md">
                        <div>
                            <p class="font-medium">{{ item.name }}</p>
                        </div>
                        <p class="font-medium">{{ item.quantity }}</p>
                        <p class="font-medium">{{ item.price }} USD</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between font-medium">
                        <p>Subtotal</p>
                        <p>537 USD</p>
                    </div>
                    <div class="flex justify-between font-medium">
                        <p>Shipping</p>
                        <p>0 USD</p>
                    </div>
                    <div class="flex justify-between font-medium text-lg">
                        <p>Total</p>
                        <p>537 USD</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue';
import stripeLogo from '@assets/images/stripeLogo.png';
import paypalLogo from '@assets/images/Paypal_logo.png';
import lemonSqueezyLogo from '@assets/images/lemon_squeezy_logo.jpeg';

const form = reactive({
    name: '',
    email: '',
    whatsapp: '',
    payment_method: '',
});

const paymentMethods = ref([
    { id: 'Stripe', name: 'Stripe', image: stripeLogo },
    { id: 'paypal', name: 'PayPal', image: paypalLogo },
    { id: 'lemonsqueezy', name: 'LemonSqueezy', image: lemonSqueezyLogo }
]);

const orderItems = ref([
    { id: 3, name: 'Rich Dad Por dad', quantity: 1, price: 179, image: 'https://m.media-amazon.com/images/I/81bsw6fnUiL._SL1500_.jpg' }
]);

const selectPaymentMethod = (methodId) => {
    form.payment_method = methodId;
};

const handleSubmit = () => {
    console.log('Form submitted:', form);
};
</script>

<style scoped>
</style>
