<template>
    <div>
        <label :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <input
            :id="name"
            :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        type="text"
        class="mt-1 block w-full rounded border-gray-300 shadow-sm"
        />
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    label:{
        type: String,
        required: false,
        default: 'Enter text here',
    },
    name:{
        type: String,
        required: false,
        default: 'text',
    },
});
</script>
