<script setup>
import { ref } from 'vue';
import Sidebar from '@/Components/Sidebar.vue';
import TopBar from '@/Components/TopBar.vue';

defineProps({ title: String });

const showingSidebar = ref(false);

const toggleSidebar = () => {
    showingSidebar.value = !showingSidebar.value;
};
</script>

<template>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <Sidebar :class="{ 'hidden': !showingSidebar, 'block': showingSidebar, 'lg:block': true }" />

        <!-- Main content area -->
        <div class="flex-1 flex flex-col">
            <!-- Top bar -->
            <TopBar :title="title" :onToggleSidebar="toggleSidebar" />

            <!-- Content -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                <slot />
            </main>
        </div>
    </div>
</template>

<style scoped>
</style>
