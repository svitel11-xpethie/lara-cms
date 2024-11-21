<template>
    <AppLayout title="Social Profiles">
        <form @submit.prevent="addSocial" class="space-y-4">
            <TextInput v-model="form.platform" label="Platform"/>
            <TextInput v-model="form.link" label="Link"/>
            <FileUpload v-model="form.icon" label="Icon"/>
            <Button type="submit">Add Social</Button>
        </form>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
            <div v-for="social in socials" :key="social.id" class="border p-4 rounded">
                <img :src="social.icon" alt="Icon" class="w-8 h-8 object-cover mx-auto"/>
                <h3 class="text-lg font-bold text-center">{{ social.platform }}</h3>
                <p class="text-sm text-center">
                    <a :href="social.link" target="_blank" class="text-blue-500 hover:underline">{{ social.link }}</a>
                </p>
                <Button variant="danger" class="mt-4" @click="deleteSocial(social.id)">Delete</Button>
            </div>
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

const toast = useToast();
const socials = ref([]);
const form = ref({
    platform: '',
    link: '',
    icon: null,
});

const fetchSocials = async () => {
    try {
        const response = await axios.get(route('admin.company.social'));
        socials.value = response.data.socials;
    } catch (error) {
        toast.error("Failed to load social profiles.");
    }
};

const addSocial = async () => {
    try {
        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        const response = await axios.post(route('admin.company.social.store'), formData);
        socials.value.push(response.data.social);
        form.value = {platform: '', link: '', icon: null};
        toast.success("Social profile added successfully!");
    } catch (error) {
        toast.error("Failed to add social profile.");
    }
};

const deleteSocial = async (id) => {
    if (confirm("Are you sure you want to delete this social profile?")) {
        try {
            await axios.delete(route('admin.company.social.delete', id));
            socials.value = socials.value.filter((social) => social.id !== id);
            toast.success("Social profile deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete social profile.");
        }
    }
};

onMounted(fetchSocials);
</script>
