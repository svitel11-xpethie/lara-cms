<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";
import TextInput from "@/Shared/TextInput.vue";
import Textarea from "@/Shared/Textarea.vue";
import Button from "@/Shared/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import { useStore } from "vuex";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";
import Draggable from 'vuedraggable';
import Checkbox from "@/Shared/Checkbox.vue";

const store = useStore();
const toast = useToast();
const faqs = ref([]);
const editingFaqId = ref(null);

const form = ref({
    question: '',
    answer: '',
    is_active: true,
});

const fetchFaqs = async () => {
    await store.dispatch("startLoading");
    try {
        const response = await axios.get(route("admin.faq.faqs"));
        faqs.value = response.data;
    } catch (error) {
        toast.error("Failed to load Faq data.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const addOrUpdateFaq = async () => {
    await store.dispatch("startLoading");
    try {
        const formData = { ...form.value };

        if (editingFaqId.value) {
            const response = await axios.put(route("admin.faq.update", editingFaqId.value), formData);
            const index = faqs.value.findIndex((m) => m.id === editingFaqId.value);
            faqs.value[index] = { ...faqs.value[index], ...response.data.faq };
            toast.success("Faq updated successfully!");
        } else {
            // Add new faq
            const response = await axios.post(route("admin.faq.store"), formData);
            faqs.value.unshift(response.data.faq);
            form.value = { question: '', answer: '', is_active: true };
            toast.success("Faq added successfully!");
        }
    } catch (error) { console.log(error)
        toast.error("Failed to add/update Faq.");
    } finally {
        editingFaqId.value = null;
        await store.dispatch("stopLoading");
    }
};

const deleteFaq = async (id) => {
    await store.dispatch("startLoading");
    if (confirm("Are you sure you want to delete this faq entry?")) {
        try {
            await axios.delete(route("admin.faq.destroy", id));
            faqs.value = faqs.value.filter((faq) => faq.id !== id);
            toast.success("Faq deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete faq.");
        } finally {
            await store.dispatch("stopLoading");
        }
    }
};

const editFaq = (faq) => {
    editingFaqId.value = faq.id;
    form.value = { ...faq };
};

const updateOrder = async () => {
    await store.dispatch("startLoading");
    try {
        const order = faqs.value.map((faq, index) => ({ id: faq.id, order: index }));
        await axios.post(route("admin.faq.updateOrder"), { order });
        toast.success("Faq order updated successfully!");
    } catch (error) {
        toast.error("Failed to update Faq order.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

onMounted(fetchFaqs);
</script>


<template>
    <AppLayout title="Faq">
        <form @submit.prevent="addOrUpdateFaq" class="space-y-4 p-8 bg-white shadow">
            <TextInput v-model="form.question" label="Question" />
            <Textarea v-model="form.answer" label="Answer" />
            <Checkbox model-value="form.is_active" label="Is Active" />
            <Button type="submit">{{ editingFaqId ? 'Update Faq' : 'Add Faq' }}</Button>
        </form>

        <draggable
            v-model="faqs"
            @end="updateOrder"
            class="overflow-x-auto mt-6 space-y-2"
        >
            <template #item="{element}">
                <div class="flex items-center justify-between bg-white border rounded-lg p-4 shadow-sm">
                    <div>
                        <p class="text-lg font-semibold">{{ element.question }}</p>
                        <p class="text-sm text-gray-500">{{ element.answer }}</p>
                    </div>
                    <div class="flex space-x-4">
                        <div class="flex items-center justify-end pr-4 space-x-2">
                            <button @click="editFaq(element)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteFaq(element.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                                <TrashIcon class="w-5 h-4 mr-1"/>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </draggable>
    </AppLayout>
</template>
