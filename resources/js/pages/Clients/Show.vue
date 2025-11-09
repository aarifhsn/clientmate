<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

const props = defineProps({
    client: Object,
});

const openLinkedIn = () => {
    window.open(props.client.linkedin_url, '_blank');
};

const deleteClient = () => {
    if (confirm('Are you sure you want to delete this client?')) {
        router.delete(`/clients/${props.client.id}`, {
            onSuccess: () => {
                toast.success('Client deleted successfully!');
                router.get('/clients');
            },
            onError: () => toast.error('Failed to delete client.'),
        });
    }
};

const getPriorityColor = (priority) => {
    const colors = {
        high: 'bg-red-100 text-red-700 border-red-200',
        medium: 'bg-yellow-100 text-yellow-700 border-yellow-200',
        low: 'bg-green-100 text-green-700 border-green-200',
    };
    return colors[priority] || 'bg-teal-100 text-teal-700 border-teal-200';
};

const formatDate = (dateString) => {
    if (!dateString) return 'N/A';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};
</script>

<template>
    <Head :title="client.name" />
    <AppLayout>
        <div class="min-h-screen bg-teal-50 p-6">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <button
                    @click="router.get('/clients')"
                    class="flex items-center gap-2 text-teal-600 transition-colors hover:text-teal-900"
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
                <div class="flex gap-3">
                    <button
                        @click="router.get(`/clients/${client.id}/edit`)"
                        class="flex items-center gap-2 rounded-lg bg-teal-700 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-teal-800"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"
                            />
                        </svg>
                        Edit
                    </button>
                    <button
                        @click="deleteClient"
                        class="flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                            />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>

            <!-- Client Card -->
            <div class="mx-auto max-w-4xl">
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <!-- Header Section -->
                    <div
                        class="border-b border-teal-200 bg-gradient-to-r from-teal-50 to-teal-100 p-6"
                    >
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="mb-3 flex items-center gap-3">
                                    <h1
                                        class="text-3xl font-bold text-teal-900"
                                    >
                                        {{ client.name }}
                                    </h1>
                                    <span
                                        v-if="client.is_favorite"
                                        class="text-2xl"
                                        title="Favorite"
                                    >
                                        <Star class="h-4 w-4 text-yellow-500" />
                                    </span>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    <span
                                        :class="
                                            getPriorityColor(client.priority)
                                        "
                                        class="inline-flex items-center rounded-full border px-3 py-1 text-xs font-semibold uppercase"
                                    >
                                        {{ client.priority }} Priority
                                    </span>
                                    <span
                                        v-if="client.connected"
                                        class="inline-flex items-center gap-1.5 rounded-full border border-green-200 bg-green-50 px-3 py-1 text-xs font-semibold text-green-700"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-green-500"
                                        ></span>
                                        Connected
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 rounded-full border border-teal-200 bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-600"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-teal-400"
                                        ></span>
                                        Not Connected
                                    </span>
                                    <span
                                        v-if="client.category"
                                        class="inline-flex items-center rounded-full border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700"
                                    >
                                        {{ client.category.name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Section -->
                    <div class="p-6">
                        <div class="grid gap-6 md:grid-cols-2">
                            <!-- LinkedIn Profile -->
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-semibold tracking-wide text-teal-500 uppercase"
                                >
                                    LinkedIn Profile
                                </label>
                                <button
                                    @click="openLinkedIn"
                                    class="flex w-full items-center gap-3 rounded-lg border border-teal-200 bg-teal-50 p-4 text-left transition-all hover:border-blue-400 hover:bg-blue-50 hover:shadow-md"
                                >
                                    <svg
                                        class="h-6 w-6 text-blue-600"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                        />
                                    </svg>
                                    <div class="flex-1 overflow-hidden">
                                        <div
                                            class="text-sm font-medium text-teal-900"
                                        >
                                            View LinkedIn Profile
                                        </div>
                                        <div
                                            class="truncate text-xs text-teal-500"
                                        >
                                            {{ client.linkedin_url }}
                                        </div>
                                    </div>
                                    <svg
                                        class="h-5 w-5 text-teal-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <!-- Next Follow Up -->
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-semibold tracking-wide text-teal-500 uppercase"
                                >
                                    Next Follow Up
                                </label>
                                <div
                                    class="flex items-center gap-3 rounded-lg border border-teal-200 bg-teal-50 p-4"
                                >
                                    <svg
                                        class="h-6 w-6 text-teal-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-teal-900"
                                    >
                                        {{
                                            formatDate(client.next_follow_up) ||
                                            'Not scheduled'
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Last Visited -->
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-semibold tracking-wide text-teal-500 uppercase"
                                >
                                    Last Visited
                                </label>
                                <div
                                    class="flex items-center gap-3 rounded-lg border border-teal-200 bg-teal-50 p-4"
                                >
                                    <svg
                                        class="h-6 w-6 text-teal-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-teal-900"
                                    >
                                        {{
                                            formatDate(
                                                client.last_visited_at,
                                            ) || 'Never'
                                        }}
                                    </span>
                                </div>
                            </div>

                            <!-- Created At -->
                            <div class="space-y-2">
                                <label
                                    class="text-sm font-semibold tracking-wide text-teal-500 uppercase"
                                >
                                    Added On
                                </label>
                                <div
                                    class="flex items-center gap-3 rounded-lg border border-teal-200 bg-teal-50 p-4"
                                >
                                    <svg
                                        class="h-6 w-6 text-teal-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4v16m8-8H4"
                                        />
                                    </svg>
                                    <span
                                        class="text-sm font-medium text-teal-900"
                                    >
                                        {{ formatDate(client.created_at) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Notes Section -->
                        <div v-if="client.notes" class="mt-6 space-y-2">
                            <label
                                class="text-sm font-semibold tracking-wide text-teal-500 uppercase"
                            >
                                Notes
                            </label>
                            <div
                                class="rounded-lg border border-teal-200 bg-teal-50 p-4"
                            >
                                <p
                                    class="text-sm leading-relaxed whitespace-pre-wrap text-teal-700"
                                >
                                    {{ client.notes }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
