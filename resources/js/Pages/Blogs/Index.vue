<script setup>
import { Link } from '@inertiajs/vue3';
import Button from '@/Shared/Button.vue';
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({ blogs: Array });
</script>

<template>
    <AppLayout title="Blogs">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Blogs</h1>
            <Button variant="primary" :href="route('admin.blogs.create')">Create Blog</Button>
        </div>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4">Title</th>
                    <th class="p-4">Slug</th>
                    <th class="p-4">Views</th>
                    <th class="p-4">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="blog in blogs" :key="blog.id">
                    <td class="p-4">{{ blog.title }}</td>
                    <td class="p-4">{{ blog.slug }}</td>
                    <td class="p-4">{{ blog.views }}</td>
                    <td class="p-4">
                        <Link :href="route('admin.blogs.edit', blog.id)" class="text-blue-600 hover:underline">Edit</Link>
                        <Link :href="route('admin.blogs.show', blog.id)" class="text-green-600 hover:underline ml-2">View</Link>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
