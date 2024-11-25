<template>
    <div>
        <label :for="name" class="block font-medium text-gray-700">{{ label }}</label>
        <select
            :id="name"
            :value="modelValue"
            @change="$emit('update:modelValue', $event.target.value)"
            class="mt-1 block w-full rounded border-gray-300 shadow-sm"
        >
            <template v-if="Array.isArray(options)">
                <option v-for="option in options" :key="option.value" :value="option.value">
                    {{ option.label }}
                </option>
            </template>
            <template v-else>
                <option v-for="(label, value) in options" :key="value" :value="value">
                    {{ label }}
                </option>
            </template>

        </select>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [String, Number],
        required: true,
    },
    label: {
        type: String,
        required: false,
        default: 'Select an option',
    },
    name: {
        type: String,
        required: false,
        default: 'select',
    },
    options: {
        type: [Array, Object],
        required: true,
        default: () => [],
    },
});

</script>
