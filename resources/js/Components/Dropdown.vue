<template>
    <div>
        <button
            @click="toggle"
            class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-left text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:outline-none"
        >
            <span>{{ title }}</span>
            <svg v-if="!isOpen" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            <svg v-else xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>
        <transition name="slide-down">
            <ul v-show="isOpen" class="mt-2 space-y-2">
                <li v-for="item in items" :key="item" class="pl-6">
                    <Link :href="item.link" class="text-gray-600 hover:text-gray-900">{{ item.name }}</Link>
                </li>
            </ul>
        </transition>
    </div>
</template>

<script setup>
import { ref } from 'vue';
const isOpen = ref(false);
const toggle = () => (isOpen.value = !isOpen.value);
defineProps(['title', 'items']);
</script>

<style scoped>
.slide-down-enter-active, .slide-down-leave-active {
    transition: all 0.3s ease-in-out;
}
.slide-down-enter-from {
    opacity: 0;
    transform: translateY(-10px);
}
.slide-down-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
