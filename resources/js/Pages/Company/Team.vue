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
            <div class="flex flex-wrap mt-6">
                <div v-for="member in members" :key="member.id"
                     class="border p-4 rounded bg-white shadow md:w-[350px] xs:w-full">
                    <img :src="member.photo" alt="Photo" class="w-24 h-24 object-cover rounded-full mx-auto" />
                    <h3 class="text-lg font-bold text-center">{{ member.name }}</h3>
                    <p class="text-sm text-gray-600 text-center">{{ member.role }}</p>
                    <p class="text-sm mt-2">{{ member.description }}</p>
                    <hr class="my-4">
                    <div class="flex justify-center space-x-4 mt-4">
                        <Button variant="secondary" @click="editMember(member)">Edit</Button>
                        <Button variant="danger" @click="deleteMember(member.id)">Delete</Button>
                    </div>
                </div>
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
