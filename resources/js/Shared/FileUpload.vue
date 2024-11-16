<template>
    <div>
        <label :for="id" class="block text-sm font-medium text-gray-700">{{ label }}</label>
        <input
            type="file"
            :id="id"
            :name="name"
            accept="image/*"
            @change="onFileChange"
            class="mt-1 block w-full text-sm text-gray-500
                   file:mr-4 file:py-2 file:px-4
                   file:rounded-full file:border-0
                   file:text-sm file:font-semibold
                   file:bg-blue-50 file:text-blue-700
                   hover:file:bg-blue-100"
        />

        <!-- Preview -->
        <div v-if="preview" class="mt-2">
            <img :src="preview" alt="Image preview" class="h-20 w-20 rounded-md object-cover" />
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    modelValue: {
        type: [File, null],
        default: null,
    },
    id: {
        type: String,
        required: false,
        default: 'file',
    },
    name: {
        type: String,
        required: false,
        default: 'file',
    },
    label: {
        type: String,
        default: 'Upload File',
    },
});

const preview = ref(null);

const emit = defineEmits(['update:modelValue']);

const onFileChange = (event) => {
    const file = event.target.files[0] || null;
    emit('update:modelValue', file);

    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.value = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        preview.value = null;
    }
};

// Clear preview when modelValue changes externally
watch(() => props.modelValue, (newValue) => {
    if (!newValue) {
        preview.value = null;
    }
});
</script>

<style scoped>
/* Optional additional styling */
</style>
