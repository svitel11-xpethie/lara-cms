<script setup>
import { TrashIcon, LinkIcon } from "@heroicons/vue/24/solid";

import {ref} from 'vue';
import {useToast} from "vue-toast-notification";

const toast = useToast();
import {useStore} from "vuex";
import AppLayout from "@/Layouts/AppLayout.vue";
import FileUpload from "@/Shared/FileUpload.vue";

const store = useStore();

const image = ref('');
const fileInput = ref(null);
const images = ref([]);

function resetImageInput() {
    if (fileInput.value) {
        fileInput.value.value = ''; // Clear the file input
    }
}

function onFileChange(e) {
    image.value = e.target.files[0];

    // Check if file size is greater than 5MB
    if (image.value.size > 5 * 1024 * 1024) {
        toast.error('Image size should not be greater than 5MB.');
        resetImageInput();
        return; // Stop the function if the file is too large
    }

    //previewImage.value = URL.createObjectURL(e.target.files[0]);
    storeData();
}

function storeData() {
    store.dispatch('startLoading')
    let formData = new FormData();
    if (image.value instanceof File)
        formData.append('image', image.value);

    axios.post('/admin/cloud/upload', formData)
        .then(response => {
            //add new image at the beginning of the array
            images.value.unshift(response.data.data)

            store.dispatch('stopLoading')
            toast.success('Image uploaded successfully');
            resetImageInput()
        })
        .catch(error => {
            store.dispatch('stopLoading')
            console.log(error);
            resetImageInput()
        });
}

function getImages() {
    store.dispatch('startLoading')
    axios.get('/admin/cloud/images')
        .then(response => {
            store.dispatch('stopLoading')
            images.value = response.data.data
        })
        .catch(error => {
            store.dispatch('stopLoading')
            console.log(error);
        });
}

getImages()


function deleteImage(id) {
    if (!confirm('Are you sure you want to delete this image?')) {
        return;
    }
    store.dispatch('startLoading')
    axios.delete('/admin/cloud/delete/' + id)
        .then(response => {
            store.dispatch('stopLoading')
            toast.success('Image deleted successfully');
            getImages()
        })
        .catch(error => {
            store.dispatch('stopLoading')
            console.log(error);
        });
}

function copyUrl(image) {
    let url = window.location.origin + image
    navigator.clipboard.writeText(url);
    toast.success('URL copied to clipboard');
}


function onClickPreviewImage(image) {
    window.open(window.location.origin + image, '_blank');
}
</script>


<template>
    <AppLayout title="Upload Images">
        <div class="flex flex-col space-y-4">
            <!-- File Upload Section -->
            <div class="flex flex-col space-y-2">
                <FileUpload v-model="image" id="image" @change="storeData" name="image" label="Upload Image" />
            </div>

            <hr class="border w-full mb-4 mt-4">

            <!-- Responsive Image Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                <div
                    v-for="image in images"
                    :key="image.id"
                    class="relative border rounded-lg overflow-hidden shadow-lg flex flex-col"
                    :class="image.orientation === 'portrait' ? 'row-span-2' : 'row-span-1'"
                >
                    <img
                        @click="onClickPreviewImage(image.image)"
                        :src="image.image_thumb"
                        alt="Image"
                        class="w-full object-cover cursor-pointer transition duration-200 transform hover:scale-105"
                        :class="image.orientation === 'portrait' ? 'h-100' : 'h-50'"
                    />

                    <!-- Overlay Buttons -->
                    <div class="absolute bg-admin-primary bg-opacity-60 rounded px-2 py-1 flex items-center top-0 right-0 m-1">
                        <button
                            @click="deleteImage(image.id)"
                            class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600 transition"
                            title="Delete Image"
                        >
                            <TrashIcon class="w-5 h-5" />
                        </button>
                        <button
                            @click="copyUrl(image.image)"
                            class="bg-blue-500 ml-2 text-white p-1 rounded-full hover:bg-blue-600 transition"
                            title="Copy URL"
                        >
                            <LinkIcon class="w-5 h-5" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
