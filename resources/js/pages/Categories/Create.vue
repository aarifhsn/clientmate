<script setup>
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';

const form = useForm({
    name: '',
    color: '#14b8a6', // Default teal-500
});

const presetColors = [
    { name: 'Teal', value: '#14b8a6' },
    { name: 'Blue', value: '#3b82f6' },
    { name: 'Indigo', value: '#6366f1' },
    { name: 'Purple', value: '#a855f7' },
    { name: 'Pink', value: '#ec4899' },
    { name: 'Red', value: '#ef4444' },
    { name: 'Orange', value: '#f97316' },
    { name: 'Amber', value: '#f59e0b' },
    { name: 'Green', value: '#22c55e' },
    { name: 'Emerald', value: '#10b981' },
    { name: 'Cyan', value: '#06b6d4' },
    { name: 'Gray', value: '#6b7280' },
];

const submitForm = () => {
    form.post('/categories', {
        onSuccess: () => {
            toast.success('Category created successfully!');
            router.get('/categories');
        },
        onError: () => {
            toast.error('Failed to create category.');
        },
    });
};
</script>

<template>
    <Head title="Create Category" />
    <AppLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <!-- Header -->
            <div class="mb-6">
                <button
                    @click="router.get('/categories')"
                    class="mb-4 flex items-center gap-2 text-gray-600 transition-colors hover:text-gray-900"
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
                <h1 class="text-3xl font-bold text-gray-900">
                    Create Category
                </h1>
                <p class="mt-1 text-sm text-gray-600">
                    Add a new category to organize your clients
                </p>
            </div>

            <!-- Form -->
            <div class="mx-auto max-w-2xl">
                <div class="rounded-lg bg-white p-6 shadow-sm">
                    <form @submit.prevent="submitForm" class="space-y-6">
                        <!-- Name -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Category Name
                                <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="text"
                                v-model="form.name"
                                placeholder="Enter category name"
                                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-teal-500 focus:ring-1 focus:ring-teal-500 focus:outline-none"
                                required
                                maxlength="255"
                            />
                            <p
                                v-if="form.errors.name"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.name }}
                            </p>
                        </div>

                        <!-- Color Picker -->
                        <div>
                            <label
                                class="mb-2 block text-sm font-medium text-gray-700"
                            >
                                Category Color
                                <span class="text-red-500">*</span>
                            </label>

                            <!-- Preset Colors -->
                            <div
                                class="mb-4 grid grid-cols-6 gap-3 sm:grid-cols-12"
                            >
                                <button
                                    v-for="preset in presetColors"
                                    :key="preset.value"
                                    type="button"
                                    @click="form.color = preset.value"
                                    class="group relative h-10 w-10 rounded-lg border-2 transition-all hover:scale-110"
                                    :class="
                                        form.color === preset.value
                                            ? 'border-teal-600 ring-2 ring-teal-600 ring-offset-2'
                                            : 'border-gray-200'
                                    "
                                    :style="{ backgroundColor: preset.value }"
                                    :title="preset.name"
                                >
                                    <svg
                                        v-if="form.color === preset.value"
                                        class="absolute inset-0 m-auto h-5 w-5 text-white drop-shadow"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="3"
                                            d="M5 13l4 4L19 7"
                                        />
                                    </svg>
                                </button>
                            </div>

                            <!-- Custom Color Input -->
                            <div
                                class="flex items-center gap-3 rounded-lg border border-gray-300 p-3"
                            >
                                <div class="flex items-center gap-3">
                                    <input
                                        type="color"
                                        v-model="form.color"
                                        class="h-10 w-20 cursor-pointer rounded border border-gray-300"
                                    />
                                    <div>
                                        <p
                                            class="text-sm font-medium text-gray-700"
                                        >
                                            Custom Color
                                        </p>
                                        <p
                                            class="font-mono text-xs text-gray-500"
                                        >
                                            {{ form.color }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <p
                                v-if="form.errors.color"
                                class="mt-2 text-sm text-red-600"
                            >
                                {{ form.errors.color }}
                            </p>
                        </div>

                        <!-- Preview -->
                        <div
                            class="rounded-lg border border-gray-200 bg-gray-50 p-4"
                        >
                            <p class="mb-3 text-sm font-medium text-gray-700">
                                Preview
                            </p>
                            <div
                                class="overflow-hidden rounded-lg bg-white shadow-sm"
                            >
                                <div
                                    class="h-2 w-full"
                                    :style="{ backgroundColor: form.color }"
                                ></div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="h-6 w-6 rounded border border-gray-200"
                                            :style="{
                                                backgroundColor: form.color,
                                            }"
                                        ></div>
                                        <span
                                            class="text-sm font-semibold text-gray-900"
                                        >
                                            {{ form.name || 'Category Name' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex gap-3 pt-4">
                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="flex-1 rounded-lg bg-teal-600 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:bg-teal-700 disabled:cursor-not-allowed disabled:opacity-50"
                            >
                                {{
                                    form.processing
                                        ? 'Creating...'
                                        : 'Create Category'
                                }}
                            </button>
                            <button
                                type="button"
                                @click="router.get('/categories')"
                                class="rounded-lg border border-gray-300 px-6 py-2.5 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
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
