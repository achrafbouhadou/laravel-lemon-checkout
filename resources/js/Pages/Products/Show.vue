<template>
    <div class="container mx-auto py-12">
      <div class="flex flex-col lg:flex-row lg:space-x-10">
        <!-- Product Image -->
        <div class="lg:w-1/2">
          <img :src="product.image" alt="product.name" class="w-full h-96 object-cover rounded-lg shadow-md">
        </div>
  
        <!-- Product Details -->
        <div class="lg:w-1/2">
          <h1 class="text-4xl font-semibold mb-4">{{ product.name }}</h1>
          <p class="text-gray-600 mb-6">{{ product.description }}</p>
          <p class="text-teal-600 font-bold text-2xl mb-6">{{ product.price }} USD</p>
  
          <!-- Buy Now Button -->
          <button 
            @click="buyNow(product.id)" 
            class="bg-teal-500 hover:bg-teal-600 text-white font-medium py-3 px-6 rounded-lg transition-colors w-full"
          >
            Buy Now
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { router } from '@inertiajs/vue3';

  
  const props = defineProps({
    product: Object,
  });
  
  
  const buyNow = (productId) => {
    router.get(`/checkout/${productId}`);

  };
  </script>
  
  <style scoped>
  /* Add any custom styles here if needed */
  </style>
  