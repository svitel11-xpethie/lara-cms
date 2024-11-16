<template>
    <div class="flex items-center">
        <input
            :id="id"
            :name="name"
            :value="value"
            :checked="modelValue"
            type="checkbox"
            class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring focus:ring-blue-500 focus:ring-opacity-50"
            @change="$emit('update:modelValue', $event.target.checked)"
        />
        <label :for="id" class="ml-2 text-sm text-gray-700">{{ label }}</label>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [Boolean, Number],
        required: true,
        default: false,
    },
    id: {
        type: String,
        required: false,
        default: '',
    },
    name: {
        type: String,
        required: false,
        default: '',
    },
    label: {
        type: String,
        default: '',
    },
    value: {
        type: [String, Number, Boolean],
        default: true,
    },
});

defineEmits(['update:modelValue']);
</script>

<style scoped>
input[type='checkbox'] {
    cursor: pointer;
}
</style>
