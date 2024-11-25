<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import TextInput from '@/Shared/TextInput.vue';
import TiptapEditor from '@/Shared/TiptapEditor.vue';
import FileUpload from '@/Shared/FileUpload.vue';
import Button from '@/Shared/Button.vue';
import {useToast} from 'vue-toast-notification';
import AppLayout from "@/Layouts/AppLayout.vue";

const toast = useToast();
const props = defineProps(['company']);

const company = ref({...props.company});

const saveCompany = async () => {
    const formData = new FormData();
    Object.entries(company.value).forEach(([key, value]) => {
        formData.append(key, value);
    });

    try {
        await axios.post(route('admin.company.updateProfile'), formData);
        toast.success('Profile updated successfully!');
    } catch (error) {
        toast.error('Failed to update profile.');
    }
};

</script>

<template>
    <AppLayout title="Company Profile">
        <form @submit.prevent="saveCompany" class="space-y-6 p-8 bg-white shadow">
            <!-- Company Details -->
            <TextInput v-model="company.name" label="Company Name" placeholder="Enter company name"/>
            <TextInput v-model="company.ceo" label="CEO" placeholder="Enter CEO name"/>
            <TextInput v-model="company.registration_number" label="Registration Number"
                       placeholder="Enter registration number"/>
            <TextInput v-model="company.address" label="Address" placeholder="Enter address"/>
            <TextInput v-model="company.phone" label="Phone" placeholder="Enter phone number"/>
            <TextInput v-model="company.phone_website" label="Phone (Website)"
                       placeholder="Enter phone for website"/>
            <TextInput v-model="company.email" label="Email" placeholder="Enter email"/>
            <TextInput v-model="company.website" label="Website" placeholder="Enter website URL"/>

            <!-- About Us -->
            <div>
                <label for="about_us" class="block text-sm font-medium text-gray-700">About Us</label>
                <TiptapEditor v-model="company.about_us" id="about_us"/>
            </div>

            <!-- Logo Upload -->
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                <FileUpload v-model="company.logo" id="logo"/>
                <img v-if="company.logo && company.logo !== 'null'" :src="company.logo" alt="Logo" class="mt-4 max-w-xs"/>
            </div>

            <!-- Submit Button -->
            <Button type="submit">Save</Button>
        </form>
    </AppLayout>
</template>
