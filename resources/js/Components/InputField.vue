<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-medium">
            {{ label }} <span v-if="required" class="text-red-500">*</span>
        </label>
        <div class="relative mt-1">
            <span v-if="iconSrc" class="absolute inset-y-0 left-0 flex items-center pl-3">
              
                <img :src="iconSrc" :alt="label" class="h-5 w-5">
            </span>
            <input 
                :id="id" 
                :type="type" 
                :name="id" 
                :class="['block w-full p-3 border border-gray-300 rounded-md', iconSrc ? 'pl-10' : '']"
                :placeholder="placeholder"
                :value="modelValue" 
                @input="$emit('update:modelValue', $event.target.value)"
                :required="required"
            >
        </div>
        <InputError :errorMessage="error" />
    </div>
</template>

<script setup>
import { defineProps, defineEmits } from 'vue';
import InputError from '@/Components/InputError.vue'; 

const props = defineProps({
    id: String,
    label: String,
    type: {
        type: String,
        default: 'text',
    },
    placeholder: String,
    modelValue: String,
    iconSrc: String,
    required: {
        type: Boolean,
        default: false,
    },
    error: {
        type: String,
        required: false,
        default: '',
    },
});

const emit = defineEmits(['update:modelValue']);
</script>
