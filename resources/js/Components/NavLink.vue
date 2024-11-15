<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
    href: String,
    active: Boolean,
});
</script>

<template>
    <Link
        :href="href"
        :class="[
            'block px-4 py-2 rounded-lg text-sm font-medium transition',
            active
                ? 'bg-admin-secondary text-white'
                : 'text-gray-300 hover:bg-gray-700 hover:text-white'
        ]"
    >
        <slot />
    </Link>
</template>

<style scoped>
</style>
