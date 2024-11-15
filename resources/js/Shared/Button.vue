<script setup>
import { defineProps, defineEmits } from 'vue';

// Props for flexibility
defineProps({
    type: {
        type: String,
        default: 'button',
    },
    variant: {
        type: String,
        default: 'primary', // primary, secondary, danger, etc.
    },
    size: {
        type: String,
        default: 'md', // sm, md, lg
    },
    disabled: {
        type: Boolean,
        default: false,
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

// Emit click event
defineEmits(['click']);

const classes = {
    base: 'inline-flex items-center justify-center font-medium rounded focus:outline-none focus:ring-2 transition',
    variants: {
        primary: 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        secondary: 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        danger: 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
    },
    sizes: {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-md',
        lg: 'px-6 py-3 text-lg',
    },
};
</script>

<template>
    <button
        :type="type"
        :disabled="disabled || loading"
        :class="[
            classes.base,
            classes.variants[variant] || classes.variants.primary,
            classes.sizes[size] || classes.sizes.md,
            { 'opacity-50 cursor-not-allowed': disabled || loading },
        ]"
        @click="$emit('click')"
    >
        <span v-if="loading" class="loader mr-2"></span>
        <slot />
    </button>
</template>

<style scoped>
.loader {
    border: 2px solid transparent;
    border-top-color: white;
    border-radius: 50%;
    width: 1rem;
    height: 1rem;
    animation: spin 0.75s linear infinite;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
