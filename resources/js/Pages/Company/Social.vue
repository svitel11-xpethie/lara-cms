<template>
    <AppLayout title="Social Profiles">
        <form @submit.prevent="addSocial" class="space-y-4 p-8 bg-white shadow">
            <TextInput v-model="form.platform" label="Platform"/>
            <TextInput v-model="form.url" label="Link"/>
            <FileUpload v-model="form.icon" label="Icon"/>
            <Button type="submit">{{ editingSocialId ? 'Update Social' : 'Add Social' }}</Button>
        </form>

        <div class="overflow-x-auto mt-6">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead>
                <tr>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Platform</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Icon</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">URL</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600 text-right">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="social in socials" :key="social.id" class="hover:bg-gray-50">
                    <td class="py-4 px-4 text-sm font-medium text-gray-900 capitalize">{{ social.platform }}</td>
                    <td class="py-4 px-4">
                        <img :src="social.icon" alt="Icon" class="w-10 h-10 object-cover rounded" />
                    </td>
                    <td class="py-4 px-4">
                        <a
                            :href="social.url"
                            target="_blank"
                            class="text-blue-500 hover:underline flex items-center"
                        >
                            <LinkIcon class="w-5 h-5 mr-1" /> {{ social.url }}
                        </a>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-end pr-4 space-x-2">
                            <button @click="editSocial(social)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteSocial(social.id)"
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
Eva@maria@2017
<script setup>
import {ref, onMounted} from "vue";
import axios from "axios";
import {useToast} from "vue-toast-notification";
import TextInput from "@/Shared/TextInput.vue";
import FileUpload from "@/Shared/FileUpload.vue";
import Button from "@/Shared/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {useStore} from "vuex";
const store = useStore();

import {LinkIcon} from "@heroicons/vue/24/solid";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";

const toast = useToast();
const socials = ref([]);
const editingSocialId = ref(null);

const form = ref({
    platform: '',
    url: '',
    icon: null,
});

const fetchSocials = async () => {
    await store.dispatch('startLoading');
    try {
        const response = await axios.get(route('admin.company.social.profiles'));
        socials.value = response.data;
    } catch (error) {console.log(error);
        toast.error("Failed to load social profiles.");
    } finally {
        await store.dispatch('stopLoading');
    }
};

const addSocial = async () => {
    await store.dispatch('startLoading');
    try {
        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        if (editingSocialId.value) {
            // Update existing social profile
            const response = await axios.post(route('admin.company.social.update', editingSocialId.value), formData);
            const index = socials.value.findIndex((m) => m.id === editingSocialId.value);
            socials.value[index] = {...socials.value[index], ...response.data.social};
            toast.success("Social profile updated successfully!");
        } else {
            // Add new social profile
            const response = await axios.post(route('admin.company.social.store'), formData);
            socials.value.unshift(response.data.social);
            toast.success("Social profile added successfully!");
        }
    } catch (error) {
        toast.error("Failed to add social profile.");
    } finally {
        editingSocialId.value = null;
        form.value = {
            platform: '',
            url: '',
            icon: null,
        };
        await store.dispatch('stopLoading');
    }
};

const deleteSocial = async (id) => {
    await store.dispatch('startLoading');
    if (confirm("Are you sure you want to delete this social profile?")) {
        try {
            await axios.delete(route('admin.company.social.delete', id));
            socials.value = socials.value.filter((social) => social.id !== id);
            toast.success("Social profile deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete social profile.");
        } finally {
            await store.dispatch('stopLoading');
        }
    }
};

const editSocial = (social) => {
    editingSocialId.value = social.id;
    form.value = {
        id: social.id,
        platform: social.platform,
        url: social.url,
        icon: null, // Photo will only be updated if a new file is selected
    };
};

onMounted(fetchSocials);
</script>
