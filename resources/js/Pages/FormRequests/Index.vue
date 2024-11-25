

<script setup>
import {ref, onMounted} from 'vue';
import axios from 'axios';
import {useToast} from 'vue-toast-notification';
import AppLayout from '@/Layouts/AppLayout.vue';
import Button from '@/Shared/Button.vue';
import {TrashIcon, PaperAirplaneIcon, AtSymbolIcon} from "@heroicons/vue/24/solid/index.js";

const formRequests = ref([]);
const toast = useToast();

const fetchRequests = async () => {
    try {
        const response = await axios.get(route('admin.form_requests.messages'));
        formRequests.value = response.data;
    } catch (error) {
        toast.error("Failed to load form requests.");
    }
};

const sendEmail = async (id) => {
    try {
        await axios.post(route('admin.form_requests.sendEmail', id));
        const request = formRequests.value.find(r => r.id === id);
        request.email_sent = true;
        toast.success("Email sent successfully!");
    } catch (error) {
        toast.error("Failed to send email.");
    }
};

const sendWhatsApp = async (id) => {
    try {
        await axios.post(route('admin.form_requests.sendWhatsApp', id));
        const request = formRequests.value.find(r => r.id === id);
        request.whatsapp_sent = true;
        toast.success("WhatsApp message sent successfully!");
    } catch (error) {
        toast.error("Failed to send WhatsApp message.");
    }
};

const deleteRequest = async (id) => {
    if (confirm("Are you sure you want to delete this request?")) {
        try {
            await axios.delete(route('admin.form_requests.destroy', id));
            formRequests.value = formRequests.value.filter(r => r.id !== id);
            toast.success("Request deleted successfully!");
        } catch (error) {
            toast.error("Failed to delete request.");
        }
    }
};

onMounted(fetchRequests);
</script>

<template>
    <AppLayout title="Form Requests">
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded-lg shadow-md">
                <thead>
                <tr>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Name</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Email</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Message</th>
                    <th class="py-3 px-4 text-left bg-gray-200 font-bold uppercase text-sm text-gray-600">Status</th>
                    <th class="py-3 px-4 text-right bg-gray-200 font-bold uppercase text-sm text-gray-600">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="request in formRequests" :key="request.id" class="hover:bg-gray-50">
                    <td class="py-4 px-4">{{ request.name }}</td>
                    <td class="py-4 px-4">{{ request.email }}</td>
                    <td class="py-4 px-4">{{ request.message }}</td>
                    <td class="py-4 px-4">
                            <span :class="{'text-green-600 bg-green-100 px-1 shadow round': request.email_sent, 'text-red-600 opacity-50': !request.email_sent}">
                                Email: {{ request.email_sent ? 'Sent' : 'Pending' }}
                            </span>
                        <br/>
                        <span
                            :class="{'text-green-600 bg-green-100 px-1 shadow round': request.whatsapp_sent, 'text-red-600 opacity-50': !request.whatsapp_sent}">
                                WhatsApp: {{ request.whatsapp_sent ? 'Sent' : 'Pending' }}
                            </span>
                    </td>
                    <td class="py-4 px-4">
                        <div class="flex justify-end space-x-2">
                            <button @click="sendEmail(request.id)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-blue-700 text-white rounded hover:bg-blue-800 flex items-center">
                                <AtSymbolIcon class="w-5 h-4 mr-1"/>
                                Send Email
                            </button>

                            <button @click="sendWhatsApp(request.id)"
                                    class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-green-700 text-white rounded hover:bg-green-800 flex items-center">
                                <PaperAirplaneIcon class="w-5 h-4 mr-1"/>
                                Send WhatsApp
                            </button>

                            <button
                                @click="deleteRequest(request.id)"
                                class="px-2 py-1 opacity-70 hover:opacity-100 transition-opacity bg-red-500 text-white rounded hover:bg-red-600 flex items-center">
                                <TrashIcon class="w-5 h-4 mr-1"/>
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </AppLayout>
</template>
