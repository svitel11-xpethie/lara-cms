import { createApp } from 'vue';
import GalleryComponent from './components/GalleryComponent.vue';

const app = createApp({});
app.component('gallery-component', GalleryComponent);
app.mount('#vue-app');
