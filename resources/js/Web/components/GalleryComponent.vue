<template>
    <div>
        <div v-if="galleryItems.length" class="gallery">
            <a
                v-for="(item, index) in galleryItems"
                :key="item.id"
                :href="item.src"
                :data-pswp-width="item.width"
                :data-pswp-height="item.height"
                @click.prevent="openGallery(index)"
            >
                <img :src="item.thumb" alt="Gallery Image" class="rounded" />
            </a>
        </div>
        <p v-else>No Images Found</p>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted, ref } from 'vue';
import PhotoSwipeLightbox from 'photoswipe/lightbox';
import 'photoswipe/style.css';

const lightbox = ref(null);
const galleryItems = ref([]);

// Load your gallery items
onMounted(() => {
    galleryItems.value = window.galleryImages || []; // Replace with your dynamic images

    lightbox.value = new PhotoSwipeLightbox({
        gallery: '.gallery',
        children: 'a',
        pswpModule: () => import('photoswipe'),
    });

    lightbox.value.init();
});

onUnmounted(() => {
    if (lightbox.value) {
        lightbox.value.destroy();
    }
});

const openGallery = (index) => {
    lightbox.value.loadAndOpen(index);
};
</script>

<style scoped>
.gallery {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;
}

.gallery img {
    max-width: 350px;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.3s ease;
}

.gallery img:hover {
    transform: scale(1.1);
}
</style>
