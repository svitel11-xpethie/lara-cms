<script setup>
import { Bars3Icon } from "@heroicons/vue/16/solid/index.js";
defineProps({ title: String, onToggleSidebar: Function });
</script>

<template>
    <header class="flex items-center justify-between h-16 bg-white shadow px-4">
        <button @click="onToggleSidebar" class="text-gray-500 lg:hidden">
            <Bars3Icon class="w-6 h-6" />
        </button>
        <h1 class="text-xl font-semibold text-gray-700">{{ title }}</h1>
    </header>
</template>
