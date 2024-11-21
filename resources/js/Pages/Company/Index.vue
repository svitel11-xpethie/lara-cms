<template>
    <AppLayout title="Company Profile">
        <form @submit.prevent="submit" class="space-y-6">
            <!-- Company Name -->
            <div>
                <TextInput v-model="form.name" label="Company Name" placeholder="Enter company name" />
            </div>

            <!-- CEO -->
            <div>
                <TextInput v-model="form.ceo" label="CEO" placeholder="Enter CEO name" />
            </div>

            <!-- Address -->
            <div>
                <Textarea v-model="form.address" label="Address" placeholder="Enter company address" />
            </div>

            <!-- Social Media -->
            <div v-for="(social, index) in form.socials" :key="index" class="space-y-2">
                <TextInput v-model="social.platform" label="Platform" placeholder="e.g., Facebook" />
                <TextInput v-model="social.link" label="URL" placeholder="Enter URL" />
            </div>

            <!-- Add Social Media Button -->
            <div>
                <Button variant="secondary" @click="addSocial">Add Social Media</Button>
            </div>

            <!-- Members -->
            <div v-for="(member, index) in form.members" :key="index" class="space-y-2">
                <TextInput v-model="member.name" label="Member Name" placeholder="Enter member name" />
                <TextInput v-model="member.role" label="Role" placeholder="Enter role" />
            </div>

            <!-- Add Member Button -->
            <div>
                <Button variant="secondary" @click="addMember">Add Member</Button>
            </div>

            <!-- Submit Button -->
            <Button type="submit" :loading="form.processing">
                {{ isEditMode ? "Save Changes" : "Add Company" }}
            </Button>
        </form>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AppLayout from "@/Layouts/AppLayout.vue";
import TextInput from "@/Shared/TextInput.vue";
import Textarea from "@/Shared/Textarea.vue";
import Button from "@/Shared/Button.vue";
import { useToast } from "vue-toast-notification";

const props = defineProps({
    company: Object,
});

const toast = useToast();

const form = useForm({
    ...props.company,
    socials: props.company.socials || [],
    members: props.company.members || [],
});

const isEditMode = !!props.company.id;

const addSocial = () => {
    form.socials.push({platform: '', link: ''});
};

const addMember = () => {
    form.members.push({name: '', role: ''});
};

const submit = () => {
    const routeName = isEditMode ? 'admin.company.update' : 'admin.company.store';
    const method = isEditMode ? 'put' : 'post';

    form[method](route(routeName, {id: props.company.id || undefined}), {
        onSuccess: () => toast.success('Company saved successfully!'),
        onError: (errors) => {
            for (const key in errors) {
                toast.error(errors[key]);
            }
        },
    });
};
</script>
