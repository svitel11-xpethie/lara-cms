<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import {
    HomeIcon,
    ChevronDownIcon,
    DocumentTextIcon,
    WrenchScrewdriverIcon,
} from "@heroicons/vue/16/solid/index.js";

const activeMenu = ref(null);

const toggleMenu = (menuId) => {
    activeMenu.value = activeMenu.value === menuId ? null : menuId;
};
</script>

<template>
    <aside class="w-64 bg-admin-primary text-white h-screen fixed lg:static">
        <!-- Sidebar Header -->
        <div class="flex items-center justify-center h-16 bg-admin-secondary">
            <h1 class="text-xl font-bold">Dashboard</h1>
        </div>

        <!-- Navigation Menu -->
        <nav class="mt-4">
            <ul class="space-y-1 list-none"> <!-- Add list-none here -->
                <!-- Existing Dashboard Menu -->
                <li class="nav-item">
                    <button
                        @click="toggleMenu('dashboards')"
                        class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition"
                    >
                        <div class="flex items-center">
                            <HomeIcon class="w-5 h-5 mr-2" />
                            Dashboards
                        </div>
                        <ChevronDownIcon
                            class="w-5 h-5 transition-transform"
                            :class="{ 'rotate-180': activeMenu === 'dashboards' }"
                        />
                    </button>
                    <div v-show="activeMenu === 'dashboards'" class="menu-dropdown pl-8 mt-2 space-y-1">
                        <Link href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-300 rounded hover:bg-gray-800 hover:text-white">
                            Overview
                        </Link>
                    </div>
                </li>

                <!-- Blogs Menu -->
                <li class="nav-item">
                    <button
                        @click="toggleMenu('blogs')"
                        class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition"
                    >
                        <div class="flex items-center">
                            <DocumentTextIcon class="w-5 h-5 mr-2" />
                            Blogs
                        </div>
                        <ChevronDownIcon
                            class="w-5 h-5 transition-transform"
                            :class="{ 'rotate-180': activeMenu === 'blogs' }"
                        />
                    </button>
                    <div v-show="activeMenu === 'blogs'" class="menu-dropdown pl-8 mt-2 space-y-1">
                        <Link
                            :href="route('admin.blogs.index')"
                            class="block px-4 py-2 text-sm text-gray-300 rounded hover:bg-gray-800 hover:text-white"
                        >
                            Blog List
                        </Link>
                        <Link
                            :href="route('admin.blogs.create')"
                            class="block px-4 py-2 text-sm text-gray-300 rounded hover:bg-gray-800 hover:text-white"
                        >
                            Create Blog
                        </Link>
                    </div>
                </li>

                <!-- Services Menu -->
                <li class="nav-item">
                    <button
                        @click="toggleMenu('services')"
                        class="flex items-center justify-between w-full px-4 py-2 text-left text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white transition"
                    >
                        <div class="flex items-center">
                            <WrenchScrewdriverIcon class="w-5 h-5 mr-2" />
                            Services
                        </div>
                        <ChevronDownIcon
                            class="w-5 h-5 transition-transform"
                            :class="{ 'rotate-180': activeMenu === 'services' }"
                        />
                    </button>
                    <div v-show="activeMenu === 'services'" class="menu-dropdown pl-8 mt-2 space-y-1">
                        <Link
                            :href="route('admin.services.index')"
                            class="block px-4 py-2 text-sm text-gray-300 rounded hover:bg-gray-800 hover:text-white"
                        >
                            Services List
                        </Link>
                        <Link
                            :href="route('admin.services.create')"
                            class="block px-4 py-2 text-sm text-gray-300 rounded hover:bg-gray-800 hover:text-white"
                        >
                            Create Service
                        </Link>
                    </div>
                </li>
            </ul>
        </nav>
    </aside>
</template>


<style scoped>
.menu-dropdown {
    overflow: hidden;
    transition: all 0.3s ease;
}
</style>
