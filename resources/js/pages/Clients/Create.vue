<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import VueTailwindDatepicker from 'vue-tailwind-datepicker';

const props = defineProps({
    categories: Array,
});

const form = useForm({
    name: '',
    linkedin_url: '',
    category_id: '',
    priority: '',
    connected: false,
    is_favorite: false,
    next_follow_up: '',
    notes: '',
});

const extractUsernameFromUrl = (url) => {
    if (!url) return '';

    // Match LinkedIn profile URL pattern
    const match = url.match(/linkedin\.com\/in\/([^\/\?]+)/);
    if (match && match[1]) {
        // Clean up the username (remove trailing slashes, query params, etc.)
        return match[1].replace(/[\/-]$/, '');
    }
    return '';
};

const submitForm = () => {
    // If name is empty, extract username from LinkedIn URL
    if (!form.name && form.linkedin_url) {
        const username = extractUsernameFromUrl(form.linkedin_url);
        if (username) {
            form.name = username;
        }
    }

    form.post('/clients', {
        onSuccess: () => {
            toast.success('Client created successfully!');
            router.get('/clients');
        },
        onError: () => {
            toast.error('Failed to create client.');
        },
    });
};
</script>

<template>
    <Head title="Add New Client" />
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
                <h1 class="text-3xl font-bold text-teal-900">Add New Client</h1>
                <p class="mt-1 text-sm text-teal-600">
                    Add a new LinkedIn client to your bookmarks
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
                                Client Name
                            </label>
                            <input
                                type="text"
                                v-model="form.name"
                                placeholder="Enter client name"
                                class="w-full rounded-lg border border-teal-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                maxlength="255"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
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
                                />
                                <p
                                    v-if="form.errors.linkedin_url"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.linkedin_url }}
                                </p>
                            </div>
                            <p class="mt-1 text-xs text-teal-500">
                                Enter the full LinkedIn profile URL
                            </p>
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
                                    <option value="">
                                        Select Category (Optional)
                                    </option>
                                    <option
                                        v-for="category in categories"
                                        :key="category.id"
                                        :value="category.id"
                                    >
                                        {{ category.name }}
                                    </option>
                                </select>
                                <p
                                    v-if="form.errors.category_id"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.category_id }}
                                </p>
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
                                <p
                                    v-if="form.errors.priority"
                                    class="mt-2 text-sm text-red-600"
                                >
                                    {{ form.errors.priority }}
                                </p>
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

                            <div class="max-w-xs">
                                <VueTailwindDatepicker
                                    v-model="form.next_follow_up"
                                    as-single
                                    placeholder="Select date"
                                    input-classes="w-full rounded-lg border-gray-300 px-4 py-2 text-sm focus:ring-teal-500 focus:border-teal-500"
                                />
                            </div>
                            <p class="mt-1 text-xs text-teal-500">
                                Schedule your next follow-up with this client
                            </p>
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
                                        ? 'Creating...'
                                        : 'Create Client'
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

                <!-- Quick Tips -->
                <div
                    class="mt-6 rounded-lg border border-blue-200 bg-blue-50 p-4"
                >
                    <div class="flex gap-3">
                        <svg
                            class="h-5 w-5 flex-shrink-0 text-blue-600"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                            />
                        </svg>
                        <div>
                            <h3 class="text-sm font-semibold text-blue-900">
                                Quick Tips
                            </h3>
                            <ul class="mt-2 space-y-1 text-xs text-blue-800">
                                <li>
                                    • Add clients' LinkedIn profiles to keep all
                                    your important connections in one place
                                </li>
                                <li>
                                    • Use categories to organize clients by
                                    industry, project, or any custom grouping
                                </li>
                                <li>
                                    • Set priority levels to focus on your most
                                    important connections
                                </li>
                                <li>
                                    • Schedule follow-ups to stay engaged with
                                    your network
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
