<!-- eslint-disable vue/block-lang -->
<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import {
    BookUser,
    Star,
    UserRoundCheck,
    Users,
    UserSearch,
} from 'lucide-vue-next';
import { computed } from 'vue';

const props = defineProps({
    stats: Object,
    recentClients: Array,
    upcomingFollowUps: Array,
    highPriorityClients: Array,
    favoriteClients: Array,
    categories: Array,
});

const formatDate = (dateString) => {
    if (!dateString) return 'Not scheduled';
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });
};

const getDaysUntil = (dateString) => {
    if (!dateString) return null;
    const today = new Date();
    const targetDate = new Date(dateString);
    const diffTime = targetDate - today;
    const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

    if (diffDays < 0) return 'Overdue';
    if (diffDays === 0) return 'Today';
    if (diffDays === 1) return 'Tomorrow';
    return `In ${diffDays} days`;
};

const openLinkedIn = (client) => {
    window.open(client.linkedin_url, '_blank');
};

const connectionPercentage = computed(() => {
    if (!props.stats?.total_clients || props.stats.total_clients === 0)
        return 0;
    return Math.round(
        (props.stats.connected_clients / props.stats.total_clients) * 100,
    );
});
</script>

<template>
    <Head title="Dashboard" />
    <AppLayout>
        <div class="min-h-screen bg-teal-50 p-6">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-teal-900">Dashboard</h1>
                <p class="mt-1 text-sm text-teal-600">
                    Welcome back! Here's what's happening with your network.
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="mb-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <!-- Total Clients -->
                <div
                    class="overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                >
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-teal-600">
                                    Total Clients
                                </p>
                                <p
                                    class="mt-2 text-3xl font-bold text-teal-900"
                                >
                                    {{ stats?.total_clients || 0 }}
                                </p>
                            </div>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100"
                            >
                                <Users class="h-6 w-6 text-teal-600" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <button
                                @click="router.get('/clients')"
                                class="text-sm font-medium text-teal-600 hover:text-teal-800"
                            >
                                View all →
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Connected Clients -->
                <div
                    class="overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                >
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-teal-600">
                                    Connected Clients
                                </p>
                                <p
                                    class="mt-2 text-3xl font-bold text-teal-900"
                                >
                                    {{ stats?.connected_clients || 0 }}
                                </p>
                            </div>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100"
                            >
                                <UserRoundCheck class="h-6 w-6 text-teal-600" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <div class="flex items-center gap-2">
                                <div
                                    class="h-2 flex-1 overflow-hidden rounded-full bg-teal-200"
                                >
                                    <div
                                        class="h-full rounded-full bg-teal-500 transition-all"
                                        :style="{
                                            width: connectionPercentage + '%',
                                        }"
                                    ></div>
                                </div>
                                <span class="text-sm font-medium text-teal-600"
                                    >{{ connectionPercentage }}%</span
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <!-- High Priority -->
                <div
                    class="overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                >
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-teal-600">
                                    High Priority
                                </p>
                                <p
                                    class="mt-2 text-3xl font-bold text-teal-900"
                                >
                                    {{ stats?.high_priority_clients || 0 }}
                                </p>
                            </div>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100"
                            >
                                <UserSearch class="h-6 w-6 text-teal-600" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-teal-600"
                                >Needs attention</span
                            >
                        </div>
                    </div>
                </div>

                <!-- Favorites -->
                <div
                    class="overflow-hidden rounded-lg bg-white shadow-sm transition-shadow hover:shadow-md"
                >
                    <div class="p-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-teal-600">
                                    Favorites
                                </p>
                                <p
                                    class="mt-2 text-3xl font-bold text-teal-900"
                                >
                                    {{ stats?.favorite_clients || 0 }}
                                </p>
                            </div>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100"
                            >
                                <BookUser class="h-6 w-6 text-teal-600" />
                            </div>
                        </div>
                        <div class="mt-4">
                            <span class="text-sm text-teal-600"
                                >Your VIP clients</span
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="mb-6 rounded-lg bg-white p-6 shadow-sm">
                <h2 class="mb-4 text-lg font-semibold text-teal-900">
                    Quick Actions
                </h2>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <button
                        @click="router.get('/clients/create')"
                        class="flex items-center gap-3 rounded-lg border-2 border-teal-300 p-4 transition-all hover:border-teal-500 hover:bg-teal-50"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100"
                        >
                            <svg
                                class="h-5 w-5 text-teal-600"
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
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-teal-900">Add Client</p>
                            <p class="text-xs text-teal-600">New connection</p>
                        </div>
                    </button>

                    <button
                        @click="router.get('/categories/create')"
                        class="flex items-center gap-3 rounded-lg border-2 border-teal-300 p-4 transition-all hover:border-teal-500 hover:bg-teal-50"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100"
                        >
                            <svg
                                class="h-5 w-5 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                                />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-teal-900">
                                New Category
                            </p>
                            <p class="text-xs text-teal-600">Organize better</p>
                        </div>
                    </button>

                    <button
                        @click="router.get('/clients?connected=1')"
                        class="flex items-center gap-3 rounded-lg border-2 border-teal-300 p-4 transition-all hover:border-teal-500 hover:bg-teal-50"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100"
                        >
                            <svg
                                class="h-5 w-5 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-teal-900">Connected</p>
                            <p class="text-xs text-teal-600">
                                View connections
                            </p>
                        </div>
                    </button>

                    <button
                        @click="router.get('/clients?priority=high')"
                        class="flex items-center gap-3 rounded-lg border-2 border-teal-300 p-4 transition-all hover:border-teal-500 hover:bg-teal-50"
                    >
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-teal-100"
                        >
                            <svg
                                class="h-5 w-5 text-teal-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                                />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="font-medium text-teal-900">
                                High Priority
                            </p>
                            <p class="text-xs text-teal-600">Focus mode</p>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div class="grid gap-6 lg:grid-cols-2">
                <!-- Upcoming Follow-ups -->
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-teal-900">
                            Upcoming Follow-ups
                        </h2>
                        <span
                            class="rounded-full bg-teal-100 px-3 py-1 text-xs font-medium text-teal-700"
                        >
                            {{ upcomingFollowUps?.length || 0 }} pending
                        </span>
                    </div>

                    <div
                        v-if="upcomingFollowUps && upcomingFollowUps.length > 0"
                        class="space-y-3"
                    >
                        <div
                            v-for="client in upcomingFollowUps"
                            :key="client.id"
                            class="flex items-center justify-between rounded-lg border border-teal-200 p-3 transition-all hover:border-teal-300 hover:bg-teal-50"
                        >
                            <div class="flex items-center gap-3 text-sm">
                                <button
                                    @click="openLinkedIn(client)"
                                    class="font-medium text-teal-800 hover:text-teal-900"
                                >
                                    {{ client.name }}
                                </button>
                                <span
                                    v-if="client.is_favorite"
                                    class="text-teal-500"
                                    ><Star class="h-3 w-3" fill="bg-teal-200"
                                /></span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm text-teal-600">{{
                                    formatDate(client.next_follow_up)
                                }}</span>
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-medium"
                                    :class="{
                                        'bg-teal-100 text-teal-700':
                                            getDaysUntil(
                                                client.next_follow_up,
                                            ) === 'Overdue' ||
                                            getDaysUntil(
                                                client.next_follow_up,
                                            ) === 'Today',
                                        'bg-teal-100 text-teal-700':
                                            getDaysUntil(
                                                client.next_follow_up,
                                            ) === 'Tomorrow',
                                        'bg-teal-100 text-teal-700': ![
                                            'Overdue',
                                            'Today',
                                            'Tomorrow',
                                        ].includes(
                                            getDaysUntil(client.next_follow_up),
                                        ),
                                    }"
                                >
                                    {{ getDaysUntil(client.next_follow_up) }}
                                </span>
                                <button
                                    @click="router.get(`/clients/${client.id}`)"
                                    class="text-teal-400 hover:text-teal-600"
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
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="py-8 text-center">
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
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                        <p class="mt-2 text-sm text-teal-600">
                            No upcoming follow-ups scheduled
                        </p>
                    </div>
                </div>

                <!-- Recent Clients -->
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <div class="mb-4 flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-teal-900">
                            Recently Added
                        </h2>
                        <button
                            @click="router.get('/clients')"
                            class="text-sm font-medium text-teal-600 hover:text-teal-700"
                        >
                            View all →
                        </button>
                    </div>

                    <div
                        v-if="recentClients && recentClients.length > 0"
                        class="space-y-3"
                    >
                        <div
                            v-for="client in recentClients"
                            :key="client.id"
                            class="flex items-center justify-between rounded-lg border border-teal-200 p-3 transition-all hover:border-teal-300 hover:bg-teal-50"
                        >
                            <div class="flex items-center gap-3">
                                <button
                                    @click="openLinkedIn(client)"
                                    class="flex items-center gap-2 text-sm font-medium text-teal-800 hover:text-teal-800"
                                >
                                    <svg
                                        class="h-5 w-5"
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
                                    class="text-teal-900"
                                    ><Star class="h-3 w-3"
                                /></span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span
                                    class="rounded-full px-2 py-1 text-xs font-semibold capitalize"
                                    :class="{
                                        'bg-teal-100 text-teal-700':
                                            client.priority === 'high',
                                        'bg-teal-100 text-teal-700':
                                            client.priority === 'medium',
                                        'bg-teal-100 text-teal-700':
                                            client.priority === 'low',
                                    }"
                                >
                                    {{ client.priority }}
                                </span>
                                <button
                                    @click="router.get(`/clients/${client.id}`)"
                                    class="text-teal-400 hover:text-teal-600"
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
                                            d="M9 5l7 7-7 7"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div v-else class="py-8 text-center">
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
                        <p class="mt-2 text-sm text-teal-600">
                            No clients added yet
                        </p>
                        <button
                            @click="router.get('/clients/create')"
                            class="mt-4 inline-flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white hover:bg-teal-700"
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
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>
                            Add Your First Client
                        </button>
                    </div>
                </div>
            </div>

            <!-- Categories Overview (if you want to add it) -->
            <div
                v-if="categories && categories.length > 0"
                class="mt-6 rounded-lg bg-white p-6 shadow-sm"
            >
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-teal-900">
                        Categories
                    </h2>
                    <button
                        @click="router.get('/categories')"
                        class="text-sm font-medium text-teal-600 hover:text-teal-700"
                    >
                        Manage →
                    </button>
                </div>

                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
                    <button
                        v-for="category in categories.slice(0, 4)"
                        :key="category.id"
                        @click="router.get(`/categories/${category.id}`)"
                        class="flex items-center gap-3 rounded-lg border border-teal-200 p-3 text-left transition-all hover:border-teal-300 hover:bg-teal-50"
                    >
                        <div
                            class="h-10 w-10 rounded-lg"
                            :style="{ backgroundColor: category.color }"
                        ></div>
                        <div>
                            <p class="font-medium text-teal-900">
                                {{ category.name }}
                            </p>
                            <p class="text-xs text-teal-600">
                                {{ category.clients_count || 0 }} clients
                            </p>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
