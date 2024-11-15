<template>
    <div
        class="loader border-4 border-blue-400 border-t-transparent rounded-full w-8 h-8"
        :class="sizeClass"
    ></div>
</template>

<script setup>
import { defineProps } from 'vue';

defineProps({
    size: {
        type: String,
        default: 'md', // sm, md, lg
    },
});

const sizeClass = {
    sm: 'w-4 h-4 border-2',
    md: 'w-8 h-8 border-4',
    lg: 'w-12 h-12 border-4',
};
</script>

<style scoped>
.loader {
    animation: spin 0.75s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
