<template>
    <div class="gallery" ref="lightGallery">
        <a v-for="image in images" :key="image.src" :href="image.src" :data-sub-html="image.caption">
            <img :src="image.thumbnail" alt="" class="rounded">
        </a>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import lightGallery from 'lightgallery';
import 'lightgallery/css/lightgallery.css';

// Props
defineProps({
    images: {
        type: Array,
        required: true
    }
});

// Reference to the gallery element
const lightGalleryRef = ref(null);

// Initialize LightGallery
onMounted(() => {
    lightGallery(lightGalleryRef.value);
    console.log('LightGallery initialized');
});
</script>
