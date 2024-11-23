<template>
    <AppLayout title="Edit Gallery Post">
        <form @submit.prevent="submit" class="space-y-4">
            <TextInput v-model="form.name" label="Name" placeholder="Enter image name" />
            <Textarea v-model="form.description" label="Description" placeholder="Enter image description" />
            <TextInput v-model="form.category" label="Category" placeholder="Enter category" />
            <TextInput v-model="form.tags" label="Tags" placeholder="Enter tags" />
            <TextInput v-model="form.alt" label="Alt Text" placeholder="Enter alt text" />
            <FileUpload v-model="form.image" label="Upload Image" />

            <div v-if="form.image_thumb">
                <img :src="form.image_thumb" alt="Image Preview" class="w-1/4 h-1/4 object-cover rounded-lg shadow-lg">
            </div>

            <Button type="submit" :loading="form.processing">Update</Button>
        </form>
    </AppLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import TextInput from '@/Shared/TextInput.vue';
import Textarea from '@/Shared/Textarea.vue';
import FileUpload from '@/Shared/FileUpload.vue';
import Button from '@/Shared/Button.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import { useToast } from 'vue-toast-notification';
import { useStore} from "vuex";
const store = useStore();
const toast = useToast();
const { props } = usePage();
console.log(props.gallery);
const form = useForm({
    name: props.gallery.name,
    description: props.gallery.description,
    category: props.gallery.category,
    tags: props.gallery.tags,
    alt: props.gallery.alt,
    image: null,
    image_thumb: props.gallery.image_thumb,
    update: true,
});

const submit = () => {
    const formData = new FormData();
    for (let key in form.data()) {
        formData.append(key, form.data()[key]);
    }

    axios.post(route('admin.galleries.update', props.gallery.id), formData)
        .then(response => {
            toast.success('Image updated successfully');
        })
        .catch(error => {
            for (let key in error.response.data.errors) {
                toast.error(error.response.data.errors[key]);
            }
        });
};
</script>
