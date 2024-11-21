<template>
    <AppLayout title="Team">
        <div>
            <!-- Add/Update Member Form -->
            <form @submit.prevent="submitMember" class="space-y-4 p-8 bg-white shadow-md">
                <TextInput v-model="form.name" label="Member Name" />
                <TextInput v-model="form.role" label="Role" />
                <Textarea v-model="form.description" label="Description" />
                <FileUpload v-model="form.photo" label="Photo" />
                <Button type="submit">{{ editingMemberId ? 'Update Member' : 'Add Member' }}</Button>
            </form>

            <!-- Members List -->
            <div class="overflow-x-auto mt-6">
                <table class="min-w-full bg-white border rounded-lg shadow-md">
                    <thead>
                    <tr>
                        <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Photo</th>
                        <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Name</th>
                        <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Role</th>
                        <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Description</th>
                        <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="member in members" :key="member.id" class="hover:bg-gray-50">
                        <td class="py-4 px-4">
                            <img
                                :src="member.photo"
                                alt="Photo"
                                class="w-16 h-16 object-cover rounded-full mx-auto"
                            />
                        </td>
                        <td class="py-4 px-4 text-sm font-medium text-gray-900">{{ member.name }}</td>
                        <td class="py-4 px-4 text-sm text-gray-600">{{ member.role }}</td>
                        <td class="py-4 px-4 text-sm text-gray-600">{{ member.description }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-2">
                                <Button
                                    variant="secondary"
                                    class="px-4 py-2 text-sm"
                                    @click="editMember(member)"
                                >
                                    Edit
                                </Button>
                                <Button
                                    variant="danger"
                                    class="px-4 py-2 text-sm"
                                    @click="deleteMember(member.id)"
                                >
                                    Delete
                                </Button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>

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

const store = useStore();
const toast = useToast();

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
            await axios.post(route('admin.company.team.update', editingMemberId.value), formData);
            const index = members.value.findIndex((m) => m.id === editingMemberId.value);
            members.value[index] = {...members.value[index], ...form.value};
            toast.success("Member updated successfully!");
        } else {
            // Add new member
            const response = await axios.post(route('admin.company.team.store'), formData);
            members.value.push(response.data.member);
            toast.success("Member added successfully!");
        }

        resetForm();
    } catch (error) {
        toast.error("Failed to submit member.");
    } finally {
        await store.dispatch('stopLoading');
    }
};

const deleteMember = async (id) => {
    await store.dispatch('startLoading');
    if (confirm("Are you sure you want to delete this member?")) {
        try {
            await axios.delete(route('admin.company.team.delete', id));
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

onMounted(fetchMembers);
</script>
