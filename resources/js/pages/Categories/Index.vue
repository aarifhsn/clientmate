<!-- eslint-disable vue/block-lang -->
<!-- eslint-disable @typescript-eslint/no-unused-vars -->
<script setup>
import { Toaster } from '@/components/ui/sonner';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import 'vue-sonner/style.css';

const props = defineProps({
    categories: Array,
    clients: Array,
});

const deleteCategory = (categoryId) => {
    if (confirm('Are you sure you want to delete this category?')) {
        router.delete(`/categories/${categoryId}`, {
            onSuccess: () => toast.success('Category deleted successfully!'),
            onError: () => toast.error('Failed to delete category.'),
        });
    }
};
</script>

<template>
    <Head title="Categories" />
    <AppLayout>
        <div class="min-h-screen bg-gray-50 p-6">
            <Toaster position="top-right" />

            <!-- Header -->
            <div class="mb-6 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
                    <p class="mt-1 text-sm text-gray-600">
                        Organize your clients with custom categories
                    </p>
                </div>
                <button
                    @click="router.get('/categories/create')"
                    class="flex items-center gap-2 rounded-lg bg-teal-600 px-4 py-2.5 text-sm font-medium text-white shadow-sm transition-colors hover:bg-teal-700"
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
                    Create Category
                </button>
            </div>

            <!-- Categories Grid -->
            <div
                class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <div
                    v-for="category in props.categories"
                    :key="category.id"
                    class="group relative overflow-hidden rounded-lg bg-white shadow-sm transition-all hover:shadow-md"
                >
                    <!-- Color Bar -->
                    <div
                        class="h-2 w-full"
                        :style="{ backgroundColor: category.color }"
                    ></div>

                    <!-- Content -->
                    <div class="p-5">
                        <div class="mb-4 flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900">
                                    {{ category.name }}
                                </h3>
                                <div class="mt-2 flex items-center gap-2">
                                    <div
                                        class="h-6 w-6 rounded border border-gray-200 shadow-sm"
                                        :style="{
                                            backgroundColor: category.color,
                                        }"
                                    ></div>
                                    <span
                                        class="font-mono text-xs text-gray-500"
                                    >
                                        {{ category.color }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2 border-t border-gray-100 pt-4">
                            <button
                                @click="
                                    router.get(`/categories/${category.id}`)
                                "
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg border border-gray-300 px-3 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-50"
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
                                View
                            </button>
                            <button
                                @click="
                                    router.get(
                                        `/categories/${category.id}/edit`,
                                    )
                                "
                                class="flex flex-1 items-center justify-center gap-2 rounded-lg bg-teal-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-teal-700"
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
                                Edit
                            </button>
                            <button
                                @click="deleteCategory(category.id)"
                                class="rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition-colors hover:bg-red-700"
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
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div
                v-if="!props.categories || props.categories.length === 0"
                class="mt-12 text-center"
            >
                <svg
                    class="mx-auto h-12 w-12 text-gray-400"
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">
                    No categories
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Get started by creating a new category.
                </p>
                <div class="mt-6">
                    <button
                        @click="router.get('/categories/create')"
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
                        Create Category
                    </button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
