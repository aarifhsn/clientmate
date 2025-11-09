<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { Star } from 'lucide-vue-next';
import { toast } from 'vue-sonner';

const props = defineProps({
    category: Object,
    clients: Array,
});

const deleteCategory = () => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(`/categories/${props.category.id}`, {
            onSuccess: () => {
                toast.success('Category deleted successfully!');
                router.get('/categories');
            },
            onError: () => toast.error('Failed to delete category.'),
        });
    }
};

const openLinkedIn = (client) => {
    window.open(client.linkedin_url, '_blank');
};

const getPriorityColor = (priority) => {
    const colors = {
        high: 'bg-red-100 text-red-700',
        medium: 'bg-yellow-100 text-yellow-700',
        low: 'bg-green-100 text-green-700',
    };
    return colors[priority] || 'bg-teal-100 text-teal-700';
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
    <Head :title="category.name" />
    <AppLayout>
        <div class="min-h-screen bg-teal-50 p-6">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <button
                    @click="router.get('/categories')"
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
                    Back to Categories
                </button>
                <div class="flex gap-3">
                    <button
                        @click="router.get(`/categories/${category.id}/edit`)"
                        class="flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-teal-700"
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
                        @click="deleteCategory"
                        class="flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
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

            <!-- Category Card -->
            <div class="mx-auto max-w-5xl">
                <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                    <!-- Header Section -->
                    <div
                        class="h-24"
                        :style="{ backgroundColor: category.color }"
                    ></div>
                    <div
                        class="border-b border-teal-200 bg-gradient-to-r from-teal-50 to-teal-100 p-6"
                    >
                        <div class="flex items-center gap-4">
                            <div
                                class="h-16 w-16 rounded-lg border-4 border-white shadow-lg"
                                :style="{ backgroundColor: category.color }"
                            ></div>
                            <div>
                                <h1 class="text-3xl font-bold text-teal-900">
                                    {{ category.name }}
                                </h1>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Section -->
                    <div
                        class="grid grid-cols-1 gap-6 border-b border-teal-200 p-6 sm:grid-cols-3"
                    >
                        <div class="text-center">
                            <p class="text-3xl font-bold text-teal-900">
                                {{ clients?.length || 0 }}
                            </p>
                            <p class="mt-1 text-sm text-teal-600">
                                Total Clients
                            </p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-teal-900">
                                {{ formatDate(category.created_at) }}
                            </p>
                            <p class="mt-1 text-sm text-teal-600">Created On</p>
                        </div>
                        <div class="text-center">
                            <p class="text-xl font-bold text-teal-900">
                                {{ formatDate(category.updated_at) }}
                            </p>
                            <p class="mt-1 text-sm text-teal-600">
                                Last Updated
                            </p>
                        </div>
                    </div>

                    <!-- Clients in this Category -->
                    <div class="p-6">
                        <h2 class="mb-4 text-xl font-semibold text-teal-900">
                            Clients in this Category
                        </h2>

                        <div
                            v-if="clients && clients.length > 0"
                            class="space-y-3"
                        >
                            <div
                                v-for="client in clients"
                                :key="client.id"
                                class="flex items-center justify-between rounded-lg border border-teal-200 bg-teal-50 p-4 transition-all hover:border-teal-300 hover:bg-white hover:shadow-sm"
                            >
                                <div class="flex items-center gap-4">
                                    <button
                                        @click="openLinkedIn(client)"
                                        class="flex items-center gap-3 font-medium text-teal-900 transition-colors hover:text-teal-800"
                                    >
                                        <svg
                                            class="h-4 w-4"
                                            fill="currentColor"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                            />
                                        </svg>
                                        {{ client.name }}
                                    </button>
                                    <span
                                        v-if="client.is_favorite"
                                        class=""
                                        title="Favorite"
                                        ><Star
                                            class="h-3 w-3"
                                            fill="text-teal-300"
                                    /></span>
                                </div>

                                <div
                                    class="flex items-center justify-between gap-3"
                                >
                                    <span
                                        :class="
                                            getPriorityColor(client.priority)
                                        "
                                        class="rounded-full px-3 py-1 text-xs font-semibold capitalize"
                                    >
                                        {{ client.priority }}
                                    </span>

                                    <span
                                        v-if="client.connected"
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-green-600"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-green-500"
                                        ></span>
                                        Connected
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-teal-500"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-teal-400"
                                        ></span>
                                        Not Connected
                                    </span>

                                    <button
                                        @click="
                                            router.get(`/clients/${client.id}`)
                                        "
                                        class="rounded-lg border border-teal-300 px-3 py-1.5 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-50"
                                        title="View Client"
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
                                                d="M9 5l7 7-7 7"
                                            />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div v-else class="py-12 text-center">
                            <svg
                                class="mx-auto h-12 w-12 text-teal-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                                />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-teal-900">
                                No clients in this category
                            </h3>
                            <p class="mt-1 text-sm text-teal-500">
                                Get started by adding clients to this category.
                            </p>
                            <div class="mt-6">
                                <button
                                    @click="router.get('/clients/create')"
                                    class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-teal-700"
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
                                            d="M12 4v16m8-8H4"
                                        />
                                    </svg>
                                    Add Client
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
