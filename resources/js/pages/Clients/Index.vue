<!-- eslint-disable vue/block-lang -->
<!-- eslint-disable @typescript-eslint/no-unused-vars -->
<script setup>
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    clients: Object,
    categories: Array,
});

const search = ref('');
const category = ref('');
const priority = ref('');
const connected = ref('');

const applyFilters = () => {
    router.get(
        '/clients',
        {
            search: search.value,
            category: category.value,
            priority: priority.value,
            connected: connected.value,
        },
        {
            preserveState: true,
        },
    );
};

const openLinkedIn = (client) => {
    window.open(`https://www.linkedin.com/in/${client.linkedin}`, '_blank');
};

const deleteClient = (clientId) => {
    router.delete(`/clients/${clientId}`, {
        preserveState: true,
    });
};
</script>

<template>
    <div class="p-6">
        <h1 class="mb-4 text-2xl font-bold">Clients</h1>

        <!-- Filters -->
        <div class="mb-4 flex flex-wrap gap-3">
            <input
                v-model="search"
                @input="applyFilters"
                placeholder="Search client..."
                class="rounded border p-2"
            />

            <select
                v-model="category"
                @change="applyFilters"
                class="rounded border p-2"
            >
                <option value="">All Categories</option>
                <option v-for="cat in categories" :key="cat.id" :value="cat.id">
                    {{ cat.name }}
                </option>
            </select>

            <select
                v-model="priority"
                @change="applyFilters"
                class="rounded border p-2"
            >
                <option value="">All Priorities</option>
                <option value="high">High</option>
                <option value="medium">Medium</option>
                <option value="low">Low</option>
            </select>

            <select
                v-model="connected"
                @change="applyFilters"
                class="rounded border p-2"
            >
                <option value="">All Connections</option>
                <option :value="1">Connected</option>
                <option :value="0">Not Connected</option>
            </select>
        </div>

        <!-- Clients Table -->
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 text-left">Name</th>
                    <th class="p-2 text-left">Category</th>
                    <th class="p-2 text-left">Priority</th>
                    <th class="p-2 text-left">Connected</th>
                    <th class="p-2 text-left">Last Visit</th>
                    <th class="p-2 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr
                    v-for="client in props.clients.data"
                    :key="client.id"
                    class="border-b hover:bg-gray-50"
                >
                    <td class="p-2">
                        <button
                            @click="openLinkedIn(client)"
                            class="text-blue-600 hover:underline"
                        >
                            {{ client.name }}
                        </button>
                    </td>
                    <td class="p-2">{{ client.category?.name ?? '-' }}</td>
                    <td class="p-2 capitalize">{{ client.priority }}</td>
                    <td class="p-2">
                        <span v-if="client.connected" class="text-green-600"
                            >🟢</span
                        >
                        <span v-else class="text-red-500">🔴</span>
                    </td>
                    <td class="p-2">{{ client.last_visited_at ?? 'Never' }}</td>
                    <td class="p-2">
                        <a href="#" class="mr-2 text-blue-500">Edit</a>
                        <button
                            @click="deleteClient(client.id)"
                            class="text-red-500"
                        >
                            Delete
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-between">
            <div>Total: {{ props.clients.total }}</div>
            <div class="flex gap-2">
                <button
                    v-for="link in props.clients.links"
                    :key="link.label"
                    v-html="link.label"
                    :disabled="!link.url"
                    @click="router.get(link.url)"
                    class="rounded border px-3 py-1"
                    :class="{ 'bg-blue-500 text-white': link.active }"
                />
            </div>
        </div>
    </div>
</template>
