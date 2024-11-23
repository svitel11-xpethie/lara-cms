<script setup>
import {Link} from '@inertiajs/vue3';
import Button from '@/Shared/Button.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {PencilSquareIcon, EyeIcon, TrashIcon} from '@heroicons/vue/24/solid';
import {ref} from "vue";

const props = defineProps({services: Array});

const originalServices = ref(props.services);

const deleteServices = (id) => {
    if (confirm('Are you sure you want to delete this service?')) {
        axios.delete(route('admin.services.destroy', id))
            .then(() => {
                const idx = originalServices.value.findIndex(service => service.id === id);
                console.log(idx);
                originalServices.value.splice(idx, 1);
            })
            .catch((error) => {
                console.log(error);
            });
    }
};


</script>

<template>
    <AppLayout title="Services">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Services</h1>
            <Button size="sm" variant="secondary" :href="route('admin.services.create')">Create Service</Button>
        </div>

        <div class="bg-white rounded shadow">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-200 text-left">
                    <th class="p-4">Title</th>
                    <th class="p-4">Image</th>
                    <th class="p-4">Views</th>
                    <th class="p-4 pr-12 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="service in originalServices" :key="service.id" class="border-b border-gray-100">
                    <td class="p-4">{{ service.title }}</td>
                    <td class="p-4">
                        <img :src="service.image_thumb" alt="" class="w-20 h-20 shadow-md rounded object-cover">
                    </td>
                    <td class="p-4">{{ service.views }}</td>
                    <td class="p-4">
                        <div class="p-4 flex space-x-2 justify-end">
                            <!-- Edit Button -->
                            <Link
                                :href="route('admin.services.edit', service.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </Link>

                            <!-- View Button -->
                            <Link
                                :href="route('admin.services.show', service.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-green-500 text-white rounded hover:bg-green-600 flex items-center">
                                <EyeIcon class="w-5 h-4 mr-1"/>
                                View
                            </Link>

                            <!-- Delete Button -->
                            <button
                                @click.prevent="deleteServices(service.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                                <TrashIcon class="w-5 h-4 mr-1"/>
                                Delete
                            </button>
                        </div>

                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
