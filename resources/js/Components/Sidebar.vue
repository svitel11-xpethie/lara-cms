<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { HomeIcon} from "@heroicons/vue/16/solid/index.js";

const activeMenu = ref(null);

const toggleMenu = (menuId) => {
    activeMenu.value = activeMenu.value === menuId ? null : menuId;
};
</script>

<template>
    <aside class="w-64 bg-admin-primary text-white h-full fixed lg:static">
        <div class="flex items-center justify-center h-16 bg-admin-secondary">
            <h1 class="text-xl font-bold">Dashboard</h1>
        </div>
        <nav class="mt-4">
            <!-- Example collapsible menu -->
            <li class="nav-item">
                <button
                    @click="toggleMenu('dashboards')"
                    class="nav-link flex items-center justify-between w-full px-4 py-2 text-sm font-medium text-left text-gray-300 hover:bg-gray-700 hover:text-white transition"
                >
                    <div class="flex items-center">
                        <HomeIcon class="w-5 h-5 mr-2" />
                        <span>Dashboards</span>
                    </div>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 transform transition"
                        :class="{ 'rotate-180': activeMenu === 'dashboards' }"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div
                    class="menu-dropdown pl-6 mt-2 space-y-2"
                    :class="{ hidden: activeMenu !== 'dashboards' }"
                >
                    <ul class="nav nav-sm flex flex-col">
                        <li class="nav-item">
                            <Link
                                href="/dashboard-analytics"
                                class="nav-link text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded"
                            >
                                Analytics
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                href="/dashboard-crm"
                                class="nav-link text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded"
                            >
                                CRM
                            </Link>
                        </li>
                        <li class="nav-item">
                            <Link
                                href="/dashboard-ecommerce"
                                class="nav-link text-gray-300 hover:text-white hover:bg-gray-800 px-4 py-2 rounded"
                            >
                                Ecommerce
                            </Link>
                        </li>
                        <!-- Add more submenu items here -->
                    </ul>
                </div>
            </li>
        </nav>
    </aside>
</template>

<style scoped>
.nav-item {
    list-style: none;
}
.menu-dropdown {
    transition: all 0.3s ease;
}
</style>
