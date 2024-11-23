
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";
import TextInput from "@/Shared/TextInput.vue";
import Textarea from "@/Shared/Textarea.vue";
import Button from "@/Shared/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useStore } from "vuex";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";
import Draggable from 'vuedraggable';

const store = useStore();
const toast = useToast();
const metas = ref([]);
const editingMetaId = ref(null);

const form = ref({
    key: '',
    value: '',
});

const fetchMetas = async () => {
    await store.dispatch("startLoading");
    try {
        const response = await axios.get(route("admin.company.seo.metas"));
        metas.value = response.data;
    } catch (error) {
        toast.error("Failed to load Meta/SEO data.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const addOrUpdateMeta = async () => {
    await store.dispatch("startLoading");
    try {
        const formData = { ...form.value };

        if (editingMetaId.value) {
            // Update existing meta
            const response = await axios.put(route("admin.company.seo.update", editingMetaId.value), formData);
            const index = metas.value.findIndex((m) => m.id === editingMetaId.value);
            metas.value[index] = { ...metas.value[index], ...response.data.seo };
            toast.success("Meta updated successfully!");
        } else {
            // Add new meta
            const response = await axios.post(route("admin.company.seo.store"), formData);
            metas.value.unshift(response.data.seo);
            toast.success("Meta added successfully!");
        }
    } catch (error) {
        toast.error("Failed to add/update Meta.");
    } finally {
        editingMetaId.value = null;
        form.value = { key: '', value: '' };
        await store.dispatch("stopLoading");
    }
};

const deleteMeta = async (id) => {
    await store.dispatch("startLoading");
    if (confirm("Are you sure you want to delete this meta entry?")) {
        try {
            await axios.delete(route("admin.company.seo.destroy", id));
            metas.value = metas.value.filter((meta) => meta.id !== id);
            toast.success("Meta deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete Meta.");
        } finally {
            await store.dispatch("stopLoading");
        }
    }
};

const editMeta = (meta) => {
    editingMetaId.value = meta.id;
    form.value = { key: meta.key, value: meta.value };
};

const updateOrder = async () => {
    await store.dispatch("startLoading");
    try {
        const order = metas.value.map((meta, index) => ({ id: meta.id, order: index }));
        await axios.post(route("admin.company.seo.updateOrder"), { order });
        toast.success("Meta order updated successfully!");
    } catch (error) {
        toast.error("Failed to update Meta order.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

onMounted(fetchMetas);
</script>


<template>
    <AppLayout title="Meta/SEO">
        <form @submit.prevent="addOrUpdateMeta" class="space-y-4 p-8 bg-white shadow">
            <TextInput v-model="form.key" label="Meta Key (e.g., seo_title, seo_description)" />
            <Textarea v-model="form.value" label="Meta Value (Content)" />
            <Button type="submit">{{ editingMetaId ? 'Update Meta' : 'Add Meta' }}</Button>
        </form>

        <draggable
            v-model="metas"
            @end="updateOrder"
            class="overflow-x-auto mt-6 space-y-2"
        >
            <template #item="{element}">
                <div class="flex items-center justify-between bg-white border rounded-lg p-4 shadow-sm">
                    <div>
                        <p class="text-lg font-semibold">{{ element.key }}</p>
                        <p class="text-sm text-gray-500">{{ element.value }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <div class="flex items-center justify-end pr-4 space-x-2">
                            <button @click="editMeta(meta)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteMeta(meta.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                                <TrashIcon class="w-5 h-4 mr-1"/>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </draggable>
    </AppLayout>
</template>
