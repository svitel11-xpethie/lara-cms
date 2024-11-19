<template>
    <AppLayout title="Upload Image to Gallery">
        <div class="flex flex-col">
            <div class="flex flex-col">
                <form @submit.prevent="submit" class="space-y-4">
                    <TextInput v-model="form.name" label="Name" placeholder="Enter image name" />
                    <Textarea v-model="form.description" label="Description" placeholder="Enter image description" />
                    <TextInput v-model="form.category" label="Category" placeholder="Enter category" />
                    <TextInput v-model="form.tags" label="Tags" placeholder="Enter tags" />
                    <TextInput v-model="form.alt" label="Alt Text" placeholder="Enter alt text" />
                    <FileUpload v-model="form.image" label="Upload Image" />

                    <Button type="submit" :loading="form.processing">Upload Image</Button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';
import TextInput from '@/Shared/TextInput.vue';
import Textarea from '@/Shared/Textarea.vue';
import FileUpload from '@/Shared/FileUpload.vue';
import Button from '@/Shared/Button.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import {useToast} from "vue-toast-notification";
const toast = useToast();

const form = useForm({
    name: '',
    description: '',
    category: '',
    tags: '',
    alt: '',
    image: null,
});

const submit = () => {
    const formData = new FormData();
    for (let key in form.data()) {
        formData.append(key, form.data()[key]);
    }

    axios.post(route('admin.galleries.store'), formData)
        .then(response => {
            form.reset();
            toast.success('Image uploaded successfully');
        })
        .catch(error => {
            for (let key in error.response.data.errors) {
                toast.error(error.response.data.errors[key]);
            }
        });
};
</script>
