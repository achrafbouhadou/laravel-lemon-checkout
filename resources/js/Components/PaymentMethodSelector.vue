<template>
    <div class="mb-6">
        <h3 class="text-lg font-medium mb-3">Payment Method</h3>
        <div class="flex space-x-4">
            <div
                v-for="method in methods"
                :key="method.id"
                @click="$emit('update:modelValue', method.id)"
                :class="['flex-1 p-4 border rounded-lg flex flex-col items-center cursor-pointer transition-colors', { 'border-teal-500 bg-teal-50': modelValue === method.id }]"
            >
                <img :src="method.image" :alt="method.name" class="h-16 mb-2">
                <p>{{ method.name }}</p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';

const props = defineProps({
    methods: Array,
    modelValue: String,
});

const emit = defineEmits(['update:modelValue']);
</script>
