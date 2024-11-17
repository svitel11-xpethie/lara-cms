<script setup>
import {Head, Link, useForm} from '@inertiajs/vue3';
import Button from '@/Shared/Button.vue';
import TextInput from '@/Shared/TextInput.vue';
import TiptapEditor from '@/Shared/TiptapEditor.vue';
import FileUpload from '@/Shared/FileUpload.vue';
import Textarea from '@/Shared/Textarea.vue';
import AppLayout from "@/Layouts/AppLayout.vue";
import Checkbox from "@/Shared/Checkbox.vue";
import {ref} from "vue"; // Use correct layout component

// Props
const props = defineProps({
    service: Object, // Service data passed from the backend
});

const copyService = ref({...props.service});

const form = useForm({
    title: copyService.value.title,
    content: copyService.value.content,
    image: null, // For new upload
    meta_tags: {
        seo_title: copyService.value.meta_tags?.seo_title || '',
        seo_description: copyService.value.meta_tags?.seo_description || '',
        facebook_title: copyService.value.meta_tags?.facebook_title || '',
        facebook_description: copyService.value.meta_tags?.facebook_description || '',
        twitter_title: copyService.value.meta_tags?.twitter_title || '',
        twitter_description: copyService.value.meta_tags?.twitter_description || '',
    },
    order: copyService.value.order || 0,
    is_active: copyService.value.is_active,
});

const submit = () => {
    form.post(route('admin.services.update', copyService.value.id), {
        onSuccess: () => form.reset('image')
    });
};
</script>

<template>
    <AppLayout title="Edit Service">
        <form @submit.prevent="submit" class="space-y-6" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT"/>
            <!-- Service Title -->
            <div>
                <TextInput v-model="form.title" label="Title" placeholder="Enter service title"/>
            </div>

            <!-- Service Content -->
            <div>
                <TiptapEditor v-model="form.content"/>
            </div>

            <!-- Upload Image -->
            <div>
                <FileUpload v-model="form.image" label="Upload New Image"/>
                <!-- Show current image if exists -->
                <div v-if="copyService.image" class="mt-2">
                    <p>Current Image:</p>
                    <img :src="`${copyService.image_thumb}`" alt="Current Image" class="h-[120px] rounded-md object-cover"/>
                </div>
            </div>

            <!-- Meta Tags for SEO -->
            <div class="bg-gray-100 p-4 rounded">
                <h3 class="font-semibold text-lg mb-2">SEO Meta Tags</h3>
                <TextInput v-model="form.meta_tags.seo_title" label="SEO Title" placeholder="Enter SEO title"/>
                <Textarea v-model="form.meta_tags.seo_description" label="SEO Description"
                          placeholder="Enter SEO description"/>
            </div>

            <!-- Meta Tags for Social Media -->
            <div class="bg-gray-100 p-4 rounded">
                <h3 class="font-semibold text-lg mb-2">Social Media Meta Tags</h3>

                <!-- Facebook Meta -->
                <h4 class="font-semibold text-md mb-1">Facebook</h4>
                <TextInput v-model="form.meta_tags.facebook_title" label="Facebook Title"
                           placeholder="Enter Facebook title"/>
                <Textarea v-model="form.meta_tags.facebook_description" label="Facebook Description"
                          placeholder="Enter Facebook description"/>

                <!-- Twitter Meta -->
                <h4 class="font-semibold text-md mb-1 mt-3">Twitter</h4>
                <TextInput v-model="form.meta_tags.twitter_title" label="Twitter Title"
                           placeholder="Enter Twitter title"/>
                <Textarea v-model="form.meta_tags.twitter_description" label="Twitter Description"
                          placeholder="Enter Twitter description"/>
            </div>

            <!-- Order -->
            <div>
                <TextInput v-model="form.order" label="Order" type="number" placeholder="Enter display order"/>
            </div>

            <div>
                <Checkbox
                    v-model="form.is_active"
                    id="is_active"
                    name="is_active"
                    label="Active Status"
                />
            </div>

            <!-- Submit Button -->
            <div>
                <Button type="submit" :loading="form.processing">Update Service</Button>
            </div>
        </form>
    </AppLayout>
</template>
