<template>
    <div>
        <label :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <textarea
            :id="name"
            :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        class="mt-1 block w-full rounded border-gray-300 shadow-sm"
        rows="4" ></textarea>
    </div>
</template>

<script setup>
defineProps({
    modelValue: String, // For v-model
    label: String,
    name: String,
    placeholder: String,
});
</script>
