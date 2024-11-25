<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";
import TextInput from "@/Shared/TextInput.vue";
import Textarea from "@/Shared/Textarea.vue";
import Checkbox from "@/Shared/Checkbox.vue";
import FileUpload from "@/Shared/FileUpload.vue";
import Button from "@/Shared/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Draggable from "vuedraggable";
import { useStore } from "vuex";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";

const toast = useToast();
const testimonials = ref([]);
const editingTestimonialId = ref(null);
const store = useStore();

const form = ref({
    name: "",
    content: "",
    is_active: true,
    image: null,
});

const fetchTestimonials = async () => {
    await store.dispatch("startLoading");
    try {
        const response = await axios.get(route("admin.testimonials.testimonials"));
        testimonials.value = response.data;
    } catch (error) {
        toast.error("Failed to load testimonials.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const submitForm = async () => {
    await store.dispatch("startLoading");
    try {
        const endpoint = editingTestimonialId.value
            ? route("admin.testimonials.update", editingTestimonialId.value)
            : route("admin.testimonials.store");

        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        await axios.post(endpoint, formData);

        toast.success(editingTestimonialId.value ? "Testimonial updated successfully!" : "Testimonial added successfully!");
        editingTestimonialId.value = null;
        form.value = {
            name: "",
            content: "",
            is_active: true,
            image: null,
        };
        fetchTestimonials();
    } catch (error) {
        toast.error("Failed to submit the testimonial.");

        // Show validation errors
        if (error.response.status === 422) {
            Object.values(error.response.data.errors).forEach((errors) => {
                errors.forEach((error) => {
                    toast.error(error);
                });
            });
        }
    } finally {
        await store.dispatch("stopLoading");
    }
};

const editTestimonial = (testimonial) => {
    editingTestimonialId.value = testimonial.id;
    form.value = { ...testimonial, image: null }; // Reset image field
};

const deleteTestimonial = async (id) => {
    if (confirm("Are you sure you want to delete this testimonial?")) {
        await store.dispatch("startLoading");
        try {
            await axios.delete(route("admin.testimonials.destroy", id));
            //delete from the testimonials array
            testimonials.value = testimonials.value.filter((testimonial) => testimonial.id !== id);
            toast.success("Testimonial deleted successfully!");
            //fetchTestimonials();
        } catch (error) {
            toast.error("Failed to delete the testimonial.");
        } finally {
            await store.dispatch("stopLoading");
        }
    }
};

const updateOrder = async () => {
    await store.dispatch("startLoading");
    try {
        const order = testimonials.value.map((testimonial, index) => ({ id: testimonial.id, order: index }));
        await axios.post(route("admin.testimonials.updateOrder"), { order: order });
        toast.success("testimonials order updated successfully!");
    } catch (error) {
        toast.error("Failed to update testimonials order.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const changeIsActive = async (testimonial) => {
    await store.dispatch("startLoading");
    try {
        await axios.post(route("admin.testimonials.update", testimonial.id), {
            is_active: testimonial.is_active,
            name: testimonial.name,
            content: testimonial.content,
            position: testimonial.position,
        });
        toast.success("Testimonial updated successfully!");
    } catch (error) {
        toast.error("Failed to update the testimonial.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

onMounted(fetchTestimonials);
</script>

<template>
    <AppLayout title="Manage Testimonials">
        <form @submit.prevent="submitForm" class="p-6 bg-white shadow rounded space-y-4">
            <TextInput v-model="form.name" label="Name" />
            <Textarea v-model="form.content" label="Feedback" rows="5" />
            <FileUpload v-model="form.image" label="Upload Image" />
            <Checkbox v-model="form.is_active" label="Active" />

            <Button type="submit">{{ editingTestimonialId ? "Update Testimonial" : "Add Testimonial" }}</Button>
        </form>

        <draggable
            v-model="testimonials"
            @end="updateOrder"
            class="mt-8 overflow-x-auto"
        >
            <template #item="{ element }">
                <div class="bg-white border-b border-gray-100 p-4 flex justify-between items-center">
                    <div class="flex">
                        <div class="w-[50px] mr-8">
                            <img
                                :src="element.image"
                                alt="Testimonial Image"
                                class="w-12 h-12 object-cover rounded-full"
                            />
                        </div>
                        <div>
                            <p class="font-bold">{{ element.name }}</p>
                            <p>{{ element.content }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <Checkbox v-model="element.is_active" @change="changeIsActive(element)" label="Active" class="mr-4" />
                        <div class="flex space-x-2">
                            <button @click="editTestimonial(element)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteTestimonial(element.id)"
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
