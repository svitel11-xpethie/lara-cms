<template>
    <AppLayout title="Gallery">
        <div class="space-y-4">
            <!-- Images Grid with Drag and Drop -->
            <draggable
                v-model="images"
                @end="updateOrder"
                item-key="id"
                class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 "
            >
                <template #item="{ element }">
                    <div class="relative border rounded-lg overflow-hidden shadow-lg  object-cover cursor-pointer transition duration-200 transform hover:scale-105">
                        <img
                            :src="element.image_thumb"
                            alt="Image"
                            class="w-full h-80 object-cover cursor-pointer"
                        />
                        <div class="absolute bg-admin-primary bg-opacity-60 rounded px-2 py-1 flex items-center top-0 right-0 m-1">
                            <button
                                @click="editImage(element.id)"
                                class="bg-blue-500 text-white p-1 rounded-full hover:bg-blue-600 transition"
                                title="Edit Image"
                            >
                                <PencilIcon class="w-4 h-4" />
                            </button>
                            <button
                                @click="deleteImage(element.id)"
                                class="bg-red-500 text-white p-1 ml-2 rounded-full hover:bg-red-600 transition"
                                title="Delete Image"
                            >
                                <TrashIcon class="w-4 h-4" />
                            </button>
                        </div>

                    </div>
                </template>
            </draggable>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import Draggable from 'vuedraggable';
import { TrashIcon, PencilIcon } from '@heroicons/vue/24/solid';
import AppLayout from "@/Layouts/AppLayout.vue";
import {router} from "@inertiajs/vue3";

const images = ref([]);

const fetchImages = async () => {
    const response = await axios.get(route('admin.galleries.images'));
    images.value = response.data.data;
};

const updateOrder = async () => {
    const order = images.value.map((image, index) => ({ id: image.id, order: index }));
    await axios.post(route('admin.galleries.updateOrder'), { order });
};

const deleteImage = async (id) => {
    if (confirm('Are you sure you want to delete this image?')) {
        await axios.delete(route('admin.galleries.destroy', id));
        images.value = images.value.filter((img) => img.id !== id);
    }
};

const editImage = (id) => {
    router.visit(route('admin.galleries.edit', id));
};

onMounted(fetchImages);
</script>

<style scoped>
.draggable {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}
</style>
