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
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Actions</th>
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
                    <td class="py-4 px-4">
                        <div class="flex items-center space-x-2">
                            <Button
                                variant="secondary"
                                class="px-4 py-2 text-sm"
                                @click="editSocial(social)"
                            >
                                Edit
                            </Button>
                            <Button
                                variant="danger"
                                class="px-4 py-2 text-sm"
                                @click="deleteSocial(social.id)"
                            >
                                Delete
                            </Button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>

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
    } catch (error) {
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

        const response = await axios.post(route('admin.company.social.store'), formData);
        socials.value.push(response.data);
        form.value = {platform: '', url: '', icon: null};

        const index = socials.value.findIndex((m) => m.id === editingSocialId.value);
        socials.value[index] = {...socials.value[index], ...form.value};
        //members.value[index] = {...members.value[index], ...form.value};

        toast.success("Social profile added successfully!");
    } catch (error) {
        toast.error("Failed to add social profile.");
    } finally {
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
