import { createApp, h } from 'vue';
import GalleryComponent from './components/GalleryComponent.vue';

createApp({
    render: () => h(GalleryComponent),
}).mount('#vue-app');
