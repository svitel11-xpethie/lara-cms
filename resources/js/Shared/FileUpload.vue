<template>
    <div>
        <label :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <input
            type="file"
            :id="name"
            @change="$emit('update:modelValue', $event.target.files[0])"
            class="block w-full mt-2"
        />
    </div>
</template>

<script setup>
defineProps({
    modelValue: File,
    label: String,
    name: String,
});
</script>
