<template>
    <AppLayout title="Team">
        <div>
            <form @submit.prevent="addMember" class="space-y-4">
                <TextInput v-model="form.name" label="Member Name" />
                <TextInput v-model="form.role" label="Role" />
                <Textarea v-model="form.description" label="Description" />
                <FileUpload v-model="form.photo" label="Photo" />
                <Button type="submit">Add Member</Button>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                <div v-for="member in members" :key="member.id" class="border p-4 rounded">
                    <img :src="member.photo" alt="Photo" class="w-24 h-24 object-cover rounded-full mx-auto" />
                    <h3 class="text-lg font-bold text-center">{{ member.name }}</h3>
                    <p class="text-sm text-gray-600 text-center">{{ member.role }}</p>
                    <p class="text-sm mt-2">{{ member.description }}</p>
                    <Button variant="danger" class="mt-4" @click="deleteMember(member.id)">Delete</Button>
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

const toast = useToast();
const members = ref([]);
const form = ref({
    name: '',
    role: '',
    description: '',
    photo: null,
});

const fetchMembers = async () => {
    try {
        const response = await axios.get(route('admin.company.team'));
        members.value = response.data.members;
    } catch (error) {
        toast.error("Failed to load team members.");
    }
};

const addMember = async () => {
    try {
        const formData = new FormData();
        Object.entries(form.value).forEach(([key, value]) => {
            formData.append(key, value);
        });

        const response = await axios.post(route('admin.company.team.store'), formData);
        members.value.push(response.data.member);
        form.value = { name: '', role: '', description: '', photo: null };
        toast.success("Member added successfully!");
    } catch (error) {
        toast.error("Failed to add member.");
    }
};

const deleteMember = async (id) => {
    if (confirm("Are you sure you want to delete this member?")) {
        try {
            await axios.delete(route('admin.company.team.delete', id));
            members.value = members.value.filter((member) => member.id !== id);
            toast.success("Member deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete member.");
        }
    }
};

onMounted(fetchMembers);
</script>
