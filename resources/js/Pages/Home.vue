<template>
    <div class="container mx-auto py-10">
      <h1 class="text-3xl font-semibold text-center mb-8">Our Products</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="product in products" :key="product.id" class="bg-white shadow-lg rounded-lg overflow-hidden">
            <img 
            :src="product.image" 
            alt="product.name" 
            class="w-full h-64 object-cover rounded-t-lg"
            >
          <div class="p-4">
            <h3 class="text-lg font-semibold mb-2">{{ product.name }}</h3>
            <p class="text-gray-700 mb-4">{{ product.description }}</p>
            <p class="text-teal-600 font-bold text-lg">{{ product.price }} MAD</p>
            <button 
              @click="goToProduct(product.id)" 
              class="mt-4 w-full bg-teal-500 hover:bg-teal-600 text-white font-medium py-2 px-4 rounded-lg transition-colors"
            >
              View Details
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup>
  import { router } from '@inertiajs/vue3';

  const props = defineProps({
    products: Array,
  });
  
  
  const goToProduct = (productId) => {
    router.get(`/products/${productId}`);
  };
  </script>
  
  <style scoped>
  </style>
  