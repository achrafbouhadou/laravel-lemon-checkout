<template>
    <div v-if="errorMessage" class="text-red-500 text-sm mt-1">
        {{ errorMessage }}
    </div>
</template>

<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    errorMessage: {
        type: String,
        required: false,
        default: '',
    },
});
</script>

<style scoped>
</style>
