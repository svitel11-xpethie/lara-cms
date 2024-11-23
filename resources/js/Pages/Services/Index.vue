<script setup>
import {Link} from '@inertiajs/vue3';
import Button from '@/Shared/Button.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {PencilSquareIcon, EyeIcon, TrashIcon} from '@heroicons/vue/24/solid';
import {ref, onMounted} from "vue";
import Draggable from 'vuedraggable';
import {useStore} from "vuex";
const store = useStore();
import {useToast} from "vue-toast-notification";
const toast = useToast();
const services = ref([]);

const deleteServices = (id) => {
    if (confirm('Are you sure you want to delete this service?')) {
        axios.delete(route('admin.services.destroy', id))
            .then(() => {
                const idx = services.value.findIndex(service => service.id === id);
                console.log(idx);
                services.value.splice(idx, 1);
            })
            .catch((error) => {
                console.log(error);
            });
    }
};


const fetchServices = async () => {
    await store.dispatch('startLoading');
    try {
        const response = await axios.get(route('admin.services.services'));
        services.value = response.data.data
        console.log(services.value);
    } catch (error) {
        toast.error("Failed to load services.");
    } finally {
        await store.dispatch('stopLoading');
    }
};


const updateOrder = async () => {
    await store.dispatch('startLoading');
    try {
        const order = services.value.map((service, index) => ({id: service.id, order: index}));
        await axios.post(route('admin.services.updateOrder'), {order});
        toast.success("Services order updated successfully.");
    } catch (error) {
        toast.error("Failed to update services order.");
    } finally {
        await store.dispatch('stopLoading');
    }
};

onMounted(() => {
    fetchServices();
});

</script>

<template>
    <AppLayout title="Services">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Services</h1>
            <Button size="sm" variant="secondary" :href="route('admin.services.create')">Create Service</Button>
        </div>

        <draggable
            v-model="services"
            @end="updateOrder"
            item-key="id"
            class="space-y-2">
            <template #item="{ element }">
                <div class="flex items-center justify-between bg-white border rounded-lg p-4 shadow-sm">
                    <div class="flex items-center space-x-4">
                        <img :src="element.image_thumb" alt="" class="w-20 h-20 shadow-md rounded object-cover">
                        <div>
                            <h2 class="text-lg font-semibold">{{ element.title }}</h2>
                            <p class="text-sm text-gray-500">{{ element.views }} views</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <Link :href="route('admin.services.edit', element.id)"
                              class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                            <PencilSquareIcon class="w-5 h-4 mr-1"/>
                            Edit
                        </Link>
                        <button
                            @click="deleteServices(element.id)"
                            class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                            <TrashIcon class="w-5 h-4 mr-1"/>
                            Delete
                        </button>
                    </div>
                </div>
            </template>
        </draggable>
    </AppLayout>
</template>
