<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import Button from '@/Shared/Button.vue';
import TextInput from '@/Shared/TextInput.vue';
import TiptapEditor from '@/Shared/TiptapEditor.vue';
import FileUpload from '@/Shared/FileUpload.vue';
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({ blog: Object });

const form = useForm({
    title: blog.title,
    content: blog.content,
    image: null,
    meta_tags: blog.meta_tags,
});

const submit = () => {
    form.put(route('admin.blogs.update', blog.id));
};
</script>

<template>
    <AppLayout title="Edit Blog">
        <form @submit.prevent="submit">
            <div class="mb-4">
                <TextInput v-model="form.title" label="Title" placeholder="Enter blog title" />
            </div>

            <div class="mb-4">
                <TiptapEditor v-model="form.content" />
            </div>

            <div class="mb-4">
                <FileUpload v-model="form.image" label="Change Image" />
            </div>

            <Button type="submit" :loading="form.processing">Update Blog</Button>
        </form>
    </AppLayout>
</template>
