
<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useToast } from "vue-toast-notification";
import TextInput from "@/Shared/TextInput.vue";
import Textarea from "@/Shared/Textarea.vue";
import FileUpload from "@/Shared/FileUpload.vue";
import Button from "@/Shared/Button.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import {useStore} from "vuex";
import {PencilSquareIcon, TrashIcon} from "@heroicons/vue/24/solid/index.js";

const store = useStore();
const toast = useToast();
import Draggable from 'vuedraggable';

const members = ref([]);
const editingMemberId = ref(null);

const form = ref({
    name: '',
    role: '',
    description: '',
    photo: null,
});

const fetchMembers = async () => {
    await store.dispatch('startLoading');
    try {
        const response = await axios.get(route('admin.company.team.members'));
        members.value = response.data;
    } catch (error) {
        toast.error("Failed to load team members.");
    } finally {
        await store.dispatch('stopLoading');
    }
};

const submitMember = async () => {
    await store.dispatch('startLoading');
    try {
        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        if (editingMemberId.value) {
            // Update existing member
            axios.post(route('admin.company.team.update', editingMemberId.value), formData).then((response) => {
                const index = members.value.findIndex((m) => m.id === editingMemberId.value);
                members.value[index] = {...members.value[index], ...response.data.member};
                fetchMembers();

                toast.success("Member updated successfully!");
            });
        } else {
            // Add new member
            const response = await axios.post(route('admin.company.team.store'), formData);
            members.value.unshift(response.data.member);
            toast.success("Member added successfully!");
        }

        resetForm();
    } catch (error) {
        toast.error("Failed to submit member.");
    } finally {
        editingMemberId.value = null;
        resetForm();
        await store.dispatch('stopLoading');
    }
};

const deleteMember = async (id) => {
    await store.dispatch('startLoading');
    if (confirm("Are you sure you want to delete this member?")) {
        try {
            await axios.delete(route('admin.company.team.destroy', id));
            members.value = members.value.filter((member) => member.id !== id);
            toast.success("Member deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete member.");
        }
    } else {
        toast.info("Member deletion cancelled!");
    }
    await store.dispatch('stopLoading');
};

const editMember = (member) => {
    editingMemberId.value = member.id;
    form.value = {
        id: member.id,
        name: member.name,
        role: member.role,
        description: member.description,
        photo: null, // Photo will only be updated if a new file is selected
    };
};

const resetForm = () => {
    editingMemberId.value = null;
    form.value = {name: '', role: '', description: '', photo: null};
};

const updateOrder = async () => {
    try {
        const order = members.value.map((member, index) => ({ id: member.id, order: index }));
        await axios.post(route('admin.company.team.updateOrder'), { order });
        toast.success('Order updated successfully!');
    } catch (error) {
        toast.error('Failed to update order.');
        console.error(error);
    }
};

onMounted(fetchMembers);
</script>

<template>
    <AppLayout title="Team">
        <div class="space-y-4">
            <!-- Add/Update Member Form -->
            <form @submit.prevent="submitMember" class="space-y-4 p-8 bg-white shadow-md">
                <div class="flex xs:flex-wrap sm:space-x-4">
                    <TextInput class="w-1/2 xs:w-full" v-model="form.name" label="Member Name" />
                    <TextInput class="w-1/2 xs:w-full" v-model="form.role" label="Role" />
                </div>

                <Textarea v-model="form.description" label="Description" />
                <FileUpload v-model="form.photo" label="Photo" />
                <Button type="submit">{{ editingMemberId ? 'Update Member' : 'Add Member' }}</Button>
            </form>

            <!-- Members List with Drag-and-Drop -->
            <draggable
                v-model="members"
                @end="updateOrder"
                item-key="id"
                class="space-y-2"
            >
                <template #item="{ element }">
                    <div class="flex items-center justify-between bg-white border rounded-lg p-4 shadow-sm">
                        <div class="flex items-center space-x-4">
                            <img
                                :src="element.photo"
                                alt="Photo"
                                class="w-16 h-16 object-cover rounded-full"
                            />
                            <div>
                                <p class="font-semibold">{{ element.name }}</p>
                                <p class="text-gray-600 text-sm">{{ element.role }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button @click="editMember(element)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-500 text-white rounded hover:bg-blue-600 flex items-center">
                                <PencilSquareIcon class="w-5 h-4 mr-1"/>
                                Edit
                            </button>

                            <button
                                @click="deleteMember(element.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                                <TrashIcon class="w-5 h-4 mr-1"/>
                                Delete
                            </button>
                        </div>
                    </div>
                </template>
            </draggable>
        </div>
    </AppLayout>
</template>
