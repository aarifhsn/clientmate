<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

const props = defineProps({
    client: Object,
    categories: Array,
});

const form = useForm({
    name: props.client.name,
    linkedin_url: props.client.linkedin_url,
    category_id: props.client.category_id,
    priority: props.client.priority,
    connected: props.client.connected,
    is_favorite: props.client.is_favorite,
    next_follow_up: props.client.next_follow_up,
    notes: props.client.notes,
});

const submitForm = () => {
    form.put(`/clients/${props.client.id}`, {
        onSuccess: () => {
            toast.success('Client updated successfully!');
            router.get('/clients');
        },
        onError: () => {
            toast.error('Failed to update client.');
        },
    });
};
</script>

<template>
    <Head title="Edit Client" />
    <AppLayout>
        <div class="min-h-screen bg-teal-50 p-6">
            <!-- Header -->
            <div class="mb-6">
                <button
                    @click="router.get('/clients')"
                    class="mb-4 flex items-center gap-2 text-teal-600 transition-colors hover:text-teal-900"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 19l-7-7 7-7"
                        />
                    </svg>
                    Back to Clients
                </button>
                <h1 class="text-3xl font-bold text-teal-900">Edit Client</h1>
                <p class="mt-1 text-sm text-teal-600">
                    Update client information
                </p>
            </div>

            <!-- Form -->
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <form @submit.prevent="submitForm" class="space-y-5">
                        <!-- Name -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-teal-700"
                            >
                                Client Name <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                v-model="form.name"
                                placeholder="Enter client name"
                                class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                required
                                maxlength="255"
                            />
                        </div>

                        <!-- LinkedIn URL -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-teal-700"
                            >
                                LinkedIn Profile URL
                                <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <svg
                                    class="absolute top-1/2 left-3 h-5 w-5 -translate-y-1/2 text-teal-400"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                    />
                                </svg>
                                <input
                                    type="url"
                                    v-model="form.linkedin_url"
                                    placeholder="https://www.linkedin.com/in/username"
                                    class="w-full rounded-lg border border-teal-300 py-2.5 pr-4 pl-10 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                    required
                                    maxlength="255"
                                />
                            </div>
                        </div>

                        <!-- Category & Priority Grid -->
                        <div class="grid gap-5 md:grid-cols-2">
                            <!-- Category -->
                            <div>
                                <label
                                    class="mb-2 block text-sm font-medium text-teal-700"
                                >
                                    Category
                                </label>
                                <select
                                    v-model="form.category_id"
                                    class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                >
                                    <option value="">Select Category</option>
                                    <option
                                        v-for="cat in categories"
                                        :key="cat.id"
                                        :value="cat.id"
                                    >
                                        {{ cat.name }}
                                    </option>
                                </select>
                            </div>

                            <!-- Priority -->
                            <div>
                                <label
                                    class="mb-2 block text-sm font-medium text-teal-700"
                                >
                                    Priority <span class="text-red-500">*</span>
                                </label>
                                <select
                                    v-model="form.priority"
                                    class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                    required
                                >
                                    <option disabled value="">
                                        Select Priority
                                    </option>
                                    <option value="high">High Priority</option>
                                    <option value="medium">
                                        Medium Priority
                                    </option>
                                    <option value="low">Low Priority</option>
                                </select>
                            </div>
                        </div>

                        <!-- Checkboxes -->
                        <div
                            class="space-y-3 rounded-lg border border-teal-200 bg-teal-50 p-4"
                        >
                            <label
                                class="flex cursor-pointer items-center gap-3"
                            >
                                <input
                                    type="checkbox"
                                    v-model="form.connected"
                                    class="h-4 w-4 rounded border-teal-300 text-teal-700 focus:ring-2 focus:ring-teal-500"
                                />
                                <div>
                                    <span
                                        class="text-sm font-medium text-teal-900"
                                        >Connected on LinkedIn</span
                                    >
                                    <p class="text-xs text-teal-600">
                                        Mark if you're already connected with
                                        this client
                                    </p>
                                </div>
                            </label>

                            <label
                                class="flex cursor-pointer items-center gap-3"
                            >
                                <input
                                    type="checkbox"
                                    v-model="form.is_favorite"
                                    class="h-4 w-4 rounded border-teal-300 text-teal-700 focus:ring-2 focus:ring-teal-500"
                                />
                                <div>
                                    <span
                                        class="text-sm font-medium text-teal-900"
                                        >Mark as Favorite ⭐</span
                                    >
                                    <p class="text-xs text-teal-600">
                                        Add to your favorites list
                                    </p>
                                </div>
                            </label>
                        </div>

                        <!-- Next Follow Up -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-teal-700"
                            >
                                Next Follow Up Date
                            </label>
                            <input
                                type="date"
                                v-model="form.next_follow_up"
                                class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                            />
                        </div>

                        <!-- Notes -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-teal-700"
                            >
                                Notes
                            </label>
                            <textarea
                                v-model="form.notes"
                                placeholder="Add any notes about this client..."
                                rows="4"
                                class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                            ></textarea>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 rounded-lg bg-teal-700 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-teal-800 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? 'Updating...'
                                        : 'Update Client'
                                }}
                            </button>
                            <button
                                type="button"
                                @click="router.get('/clients')"
                                class="rounded-lg border border-teal-300 px-6 py-2.5 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-50"
                            >
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
