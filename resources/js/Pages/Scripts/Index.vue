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
import SelectInput from "@/Shared/SelectInput.vue";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";

const toast = useToast();
const scripts = ref([]);
const editingScriptId = ref(null);
const store = useStore();

const form = ref({
    name: "",
    script: "",
    position: "footer",
    is_active: true,
    image: null,
});

const fetchScripts = async () => {
    await store.dispatch("startLoading");
    try {
        const response = await axios.get(route("admin.scripts.scripts"));
        scripts.value = response.data.data;
    } catch (error) {
        toast.error("Failed to load scripts.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const submitForm = async () => {
    await store.dispatch("startLoading");
    try {
        const endpoint = editingScriptId.value
            ? route("admin.scripts.update", editingScriptId.value)
            : route("admin.scripts.store");

        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        await axios.post(endpoint, formData);

        toast.success(editingScriptId.value ? "Script updated successfully!" : "Script added successfully!");
        editingScriptId.value = null;
        form.value = {
            name: "",
            script: "",
            position: "footer",
            is_active: true,
            image: null,
        };
        fetchScripts();
    } catch (error) {
        toast.error("Failed to submit the script.");

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

const editScript = (script) => { console.log(script);
    editingScriptId.value = script.id;
    form.value = { ...script, image: null }; // Reset image field
};

const deleteScript = async (id) => {
    if (confirm("Are you sure you want to delete this script?")) {
        await store.dispatch("startLoading");
        try {
            await axios.delete(route("admin.scripts.destroy", id));
            toast.success("Script deleted successfully!");
            fetchScripts();
        } catch (error) {
            toast.error("Failed to delete the script.");
        } finally {
            await store.dispatch("stopLoading");
        }
    }
};

const updateOrder = async () => {
    await store.dispatch("startLoading");
    try {
        const order = scripts.value.map((script, index) => ({ id: script.id, order: index }));
        await axios.post(route("admin.scripts.updateOrder"), { order: order });
        toast.success("Scripts order updated successfully!");
    } catch (error) {
        toast.error("Failed to update scripts order.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const changeIsActive = async (script) => {
    await store.dispatch("startLoading");
    try {
        await axios.put(route("admin.scripts.update", script.id), {
            is_active: script.is_active,
            name: script.name,
            script: script.script,
            position: script.position,
        });
        toast.success("Script updated successfully!");
    } catch (error) {
        toast.error("Failed to update the script.");
    } finally {
        await store.dispatch("stopLoading");
    }
};

const optionsSelect = {
    head: "Head",
    bodyTop: "Body Top",
    bodyBottom: "Body Bottom",
    footer: "Footer",
};

onMounted(fetchScripts);
</script>

<template>
    <AppLayout title="Manage Scripts">
        <form @submit.prevent="submitForm" class="p-6 bg-white shadow rounded space-y-4">
            <TextInput v-model="form.name" label="Script Name" />
            <Textarea v-model="form.script" label="Script Content" rows="5" />
            <SelectInput :options="optionsSelect" v-model="form.position" label="Position" />
            <FileUpload v-model="form.image" label="Upload Image" />
            <Checkbox v-model="form.is_active" label="Active" />

            <Button type="submit">{{ editingScriptId ? "Update Script" : "Add Script" }}</Button>
        </form>

        <draggable
            v-model="scripts"
            @end="updateOrder"
            class="mt-8 overflow-x-auto"
        >
            <template #item="{ element }">
                <div class="bg-white border-b border-gray-100 p-4 flex justify-between items-center">
                    <div class="flex">
                        <div class="w-[50px] mr-8">
                            <img
                                :src="element.image"
                                alt="Script Image"
                                class="w-12 h-12 object-cover rounded-full"
                            />
                        </div>
                        <div>
                            <p class="font-bold">{{ element.name }}</p>
                            <p class="text-sm text-gray-500 capitalize">Position: {{ element.position }}</p>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <Checkbox v-model="element.is_active" @change="changeIsActive(element)" label="Active" class="mr-4" />
                        <div class="flex space-x-2">
                            <button @click="editScript(element)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteScript(element.id)"
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
