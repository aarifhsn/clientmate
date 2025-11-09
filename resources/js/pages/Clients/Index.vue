<!-- eslint-disable vue/block-lang -->
<!-- eslint-disable @typescript-eslint/no-unused-vars -->
<script setup>
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import axios from 'axios';
import { Star } from 'lucide-vue-next';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';

const props = defineProps({
    clients: Object,
    categories: Array,
});

const search = ref('');
const category = ref('');
const priority = ref('');
const connected = ref('');
const favorite = ref('');

const sortBy = ref('last_visited_at');
const sortOrder = ref('desc');

const toggleSort = (field) => {
    if (sortBy.value === field) {
        sortOrder.value = sortOrder.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortBy.value = field;
        sortOrder.value = 'desc';
    }
    applyFilters();
};

const applyFilters = () => {
    router.get(
        '/clients',
        {
            search: search.value,
            category: category.value,
            priority: priority.value,
            connected: connected.value,
            favorite: favorite.value,
            sort_by: sortBy.value,
            sort_order: sortOrder.value,
        },
        {
            preserveState: true,
        },
    );
};

const openLinkedIn = async (client) => {
    // Open the LinkedIn profile in a new tab
    window.open(client.linkedin_url, '_blank');

    // Update last visited timestamp
    try {
        await axios.post(`/clients/${client.id}/last-visited`);

        toast.success(`${client.name}'s last visit updated`);
        applyFilters(); // refresh table
    } catch (error) {
        toast.error('Failed to update last visited time');
        console.error(error);
    }
};

const deleteClient = (clientId) => {
    if (confirm('Are you sure you want to delete this client?')) {
        router.delete(`/clients/${clientId}`, {
            onSuccess: () => toast.success('Client deleted successfully!'),
            onError: () => toast.error('Failed to delete client.'),
        });
    }
};

const getPriorityColor = (priority) => {
    const colors = {
        high: 'text-red-800',
        medium: 'text-yellow-800',
        low: 'text-teal-800',
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
// check the last visited filter
const last_visited_at = ref('');

const toggleLastVisitedFilter = () => {
    last_visited_at.value =
        last_visited_at.value === '' ? 'last_visited_at' : '';
    applyFilters();
};
</script>

<template>
    <Head title="Clients" />
    <AppLayout>
        <div class="min-h-screen bg-teal-50 p-6">
            <Toaster position="top-right" />

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-teal-900">
                        LinkedIn Clients
                    </h1>
                    <p class="mt-1 text-sm text-teal-600">
                        Manage your LinkedIn client bookmarks
                    </p>
                </div>
                <button
                    @click="router.get('/clients/create')"
                    class="flex items-center gap-2 rounded-lg bg-teal-700 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-teal-800"
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
                    Add New Client
                </button>
            </div>

            <!-- Filters -->
            <div class="mb-6 rounded-lg bg-white p-4 shadow-sm">
                <div class="grid gap-3 md:grid-cols-2 lg:grid-cols-5">
                    <div class="relative">
                        <svg
                            class="absolute top-1/2 left-3 h-5 w-5 -translate-y-1/2 text-teal-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                        <input
                            v-model="search"
                            @input="applyFilters"
                            placeholder="Search clients..."
                            class="w-full rounded-lg border border-teal-300 py-2 pr-4 pl-10 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                        />
                    </div>

                    <select
                        v-model="category"
                        @change="applyFilters"
                        class="w-full rounded-lg border border-teal-300 px-4 py-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                    >
                        <option value="">All Categories</option>
                        <option
                            v-for="cat in categories"
                            :key="cat.id"
                            :value="cat.id"
                        >
                            {{ cat.name }}
                        </option>
                    </select>

                    <select
                        v-model="priority"
                        @change="applyFilters"
                        class="w-full rounded-lg border border-teal-300 px-4 py-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                    >
                        <option value="">All Priorities</option>
                        <option value="high">High Priority</option>
                        <option value="medium">Medium Priority</option>
                        <option value="low">Low Priority</option>
                    </select>

                    <select
                        v-model="connected"
                        @change="applyFilters"
                        class="w-full rounded-lg border border-teal-300 px-4 py-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                    >
                        <option value="">All Connections</option>
                        <option :value="1">Connected</option>
                        <option :value="0">Not Connected</option>
                    </select>

                    <select
                        v-model="favorite"
                        @change="applyFilters"
                        class="w-full rounded-lg border border-teal-300 px-4 py-2 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                    >
                        <option value="">All Clients</option>
                        <option :value="1">⭐ Favorites Only</option>
                        <option :value="0">Non-Favorites</option>
                    </select>
                </div>
            </div>

            <!-- Clients Table -->
            <div class="overflow-hidden rounded-lg bg-white shadow-sm">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-teal-200">
                        <thead class="bg-teal-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    Client
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    Category
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    Priority
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    <button
                                        @click="toggleSort('last_visited_at')"
                                        class="flex items-center gap-2 hover:text-teal-900"
                                    >
                                        Last Visit
                                        <span
                                            v-if="sortBy === 'last_visited_at'"
                                        >
                                            {{
                                                sortOrder === 'asc' ? '↑' : '↓'
                                            }}
                                        </span>
                                    </button>
                                </th>
                                <th
                                    class="px-6 py-3 text-right text-xs font-semibold tracking-wider text-teal-700 uppercase"
                                >
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-teal-200 bg-white">
                            <tr
                                v-for="client in props.clients.data"
                                :key="client.id"
                                class="transition-colors hover:bg-teal-50"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <button
                                            @click="openLinkedIn(client)"
                                            class="relative flex cursor-pointer items-center gap-2 font-medium text-teal-900 capitalize transition-colors hover:text-teal-900"
                                        >
                                            <svg
                                                class="h-3 w-3"
                                                fill="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                                />
                                            </svg>
                                            {{ client.name }}
                                            <span
                                                v-if="client.is_favorite"
                                                class="absolute top-0 -right-2 flex items-center gap-2 text-teal-800"
                                                title="Favorite"
                                                ><Star
                                                    class="h-2 w-2"
                                                    fill="bg-teal-200"
                                                />
                                            </span>
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        v-if="client.category"
                                        class="inline-flex rounded bg-teal-100 px-3 py-1 text-xs font-medium text-teal-900"
                                    >
                                        {{ client.category.name }}
                                    </span>
                                    <span v-else class="text-sm text-teal-400"
                                        >-</span
                                    >
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        :class="
                                            getPriorityColor(client.priority)
                                        "
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold capitalize"
                                    >
                                        {{ client.priority }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        v-if="client.connected"
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-teal-700"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-teal-500"
                                        ></span>
                                        Connected
                                    </span>
                                    <span
                                        v-else
                                        class="inline-flex items-center gap-1.5 text-sm font-medium text-teal-400"
                                    >
                                        <span
                                            class="h-2 w-2 rounded-full bg-teal-400"
                                        ></span>
                                        Not Connected
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm whitespace-nowrap text-teal-600"
                                >
                                    {{
                                        formatDate(client.last_visited_at) ||
                                        'Never'
                                    }}
                                </td>
                                <td
                                    class="px-6 py-4 text-right whitespace-nowrap"
                                >
                                    <div
                                        class="flex items-center justify-end gap-2"
                                    >
                                        <button
                                            @click="
                                                router.get(
                                                    `/clients/${client.id}`,
                                                )
                                            "
                                            class="rounded-lg border border-teal-300 px-3 py-1.5 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-50"
                                            title="View"
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
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                />
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                />
                                            </svg>
                                        </button>
                                        <button
                                            @click="
                                                router.get(
                                                    `/clients/${client.id}/edit`,
                                                )
                                            "
                                            class="rounded-lg border border-teal-300 px-3 py-1.5 text-sm font-medium text-teal-700 transition-colors hover:bg-teal-50"
                                            title="Edit"
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
                                        </button>
                                        <button
                                            @click="deleteClient(client.id)"
                                            class="rounded-lg bg-teal-800 px-3 py-1.5 text-sm font-medium text-white transition-colors hover:bg-red-700"
                                            title="Delete"
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
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div
                    class="flex items-center justify-between border-t border-teal-200 bg-white px-6 py-4"
                >
                    <div class="flex items-center text-sm text-teal-700">
                        <span class="font-medium"
                            >Total: {{ props.clients.total }} clients</span
                        >
                    </div>
                    <div class="flex gap-1">
                        <button
                            v-for="link in props.clients.links"
                            :key="link.label"
                            v-html="link.label"
                            :disabled="!link.url"
                            @click="link.url && router.get(link.url)"
                            class="min-w-[2.5rem] rounded-lg border px-3 py-2 text-sm font-medium transition-colors disabled:cursor-not-allowed disabled:opacity-50"
                            :class="
                                link.active
                                    ? 'border-teal-700 bg-teal-700 text-white'
                                    : 'border-teal-300 bg-white text-teal-700 hover:bg-teal-50'
                            "
                        />
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
