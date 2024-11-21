<script setup>
import { defineProps, defineEmits, computed } from 'vue';

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
    href: {
        type: String,
        default: null,
    },
    target: {
        type: String,
        default: '_self', // for links (_self, _blank, etc.)
    },
});

// Emit click event
defineEmits(['click']);

// Dynamic classes
const classes = computed(() => ({
    base: 'inline-flex items-center justify-center font-medium rounded focus:outline-none focus:ring-2 transition',
    variants: {
        primary: 'bg-admin-primary text-white hover:opacity-90',
        secondary: 'bg-admin-secondary text-white hover:opacity-90',
        danger: 'bg-red-500 text-white hover:bg-opacity-90',
    },
    sizes: {
        sm: 'px-3 py-1.5 text-sm',
        md: 'px-4 py-2 text-md',
        lg: 'px-6 py-3 text-lg',
    },
    disabled: 'opacity-50 cursor-not-allowed',
}));
</script>

<template>
    <component
        :is="href ? 'a' : 'button'"
        :href="href"
        :target="href ? target : null"
        :type="!href ? type : null"
        :disabled="!href && (disabled || loading)"
        :class="[
            classes.base,
            classes.variants[variant] || classes.variants.primary,
            classes.sizes[size] || classes.sizes.md,
            { [classes.disabled]: disabled || loading },
        ]"
        @click="!href && $emit('click')"
    >
        <span v-if="loading" class="loader mr-2"></span>
        <slot/>
    </component>
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
