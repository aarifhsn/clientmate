<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { UserRoundCog } from 'lucide-vue-next';

const user = usePage().props.auth?.user;

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});
</script>

<template>
    <Head title="Welcome to LinkedIn Client Manager" />

    <div
        class="min-h-screen bg-gradient-to-br from-gray-50 via-white to-teal-50"
    >
        <!-- Navigation -->
        <nav class="border-b border-gray-200 bg-white/80 backdrop-blur-sm">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <!-- Logo -->
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-br from-teal-500 to-teal-600 shadow-lg"
                        >
                            <svg
                                viewBox="0 0 200 200"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <!-- Background Gradient -->
                                <defs>
                                    <linearGradient
                                        id="bgGradient"
                                        x1="0%"
                                        y1="0%"
                                        x2="100%"
                                        y2="100%"
                                    >
                                        <stop
                                            offset="0%"
                                            style="
                                                stop-color: #14b8a6;
                                                stop-opacity: 1;
                                            "
                                        />
                                        <stop
                                            offset="100%"
                                            style="
                                                stop-color: #0891b2;
                                                stop-opacity: 1;
                                            "
                                        />
                                    </linearGradient>

                                    <linearGradient
                                        id="bookmarkGradient"
                                        x1="0%"
                                        y1="0%"
                                        x2="0%"
                                        y2="100%"
                                    >
                                        <stop
                                            offset="0%"
                                            style="
                                                stop-color: #ffffff;
                                                stop-opacity: 1;
                                            "
                                        />
                                        <stop
                                            offset="100%"
                                            style="
                                                stop-color: #e0f2fe;
                                                stop-opacity: 1;
                                            "
                                        />
                                    </linearGradient>

                                    <!-- Shadow -->
                                    <filter
                                        id="shadow"
                                        x="-50%"
                                        y="-50%"
                                        width="200%"
                                        height="200%"
                                    >
                                        <feDropShadow
                                            dx="0"
                                            dy="4"
                                            stdDeviation="8"
                                            flood-opacity="0.3"
                                        />
                                    </filter>
                                </defs>

                                <!-- Rounded Square Background -->
                                <rect
                                    x="10"
                                    y="10"
                                    width="180"
                                    height="180"
                                    rx="40"
                                    fill="url(#bgGradient)"
                                    filter="url(#shadow)"
                                />

                                <!-- LinkedIn "in" inspired element (stylized) -->
                                <g transform="translate(100, 80)">
                                    <!-- Left bar (i) -->
                                    <rect
                                        x="-45"
                                        y="-15"
                                        width="14"
                                        height="14"
                                        rx="7"
                                        fill="#ffffff"
                                        opacity="0.9"
                                    />
                                    <rect
                                        x="-45"
                                        y="5"
                                        width="14"
                                        height="40"
                                        rx="3"
                                        fill="#ffffff"
                                        opacity="0.9"
                                    />

                                    <!-- Right shape (n) -->
                                    <path
                                        d="M -20 5 L -20 45 L -8 45 L -8 28 Q -8 18 2 18 Q 12 18 12 28 L 12 45 L 24 45 L 24 25 Q 24 5 2 5 Q -8 5 -12 12 L -12 5 Z"
                                        fill="#ffffff"
                                        opacity="0.9"
                                    />
                                </g>

                                <!-- Bookmark Icon (bottom right) -->
                                <g transform="translate(130, 120)">
                                    <path
                                        d="M 0 0 L 30 0 L 30 50 L 15 40 L 0 50 Z"
                                        fill="url(#bookmarkGradient)"
                                        stroke="#0891b2"
                                        stroke-width="2.5"
                                        filter="url(#shadow)"
                                    />

                                    <!-- Checkmark inside bookmark -->
                                    <path
                                        d="M 9 18 L 13 24 L 22 12"
                                        fill="none"
                                        stroke="#14b8a6"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                    />
                                </g>

                                <!-- Small accent dots for design -->
                                <circle
                                    cx="40"
                                    cy="160"
                                    r="4"
                                    fill="#ffffff"
                                    opacity="0.3"
                                />
                                <circle
                                    cx="55"
                                    cy="165"
                                    r="3"
                                    fill="#ffffff"
                                    opacity="0.3"
                                />
                                <circle
                                    cx="160"
                                    cy="40"
                                    r="5"
                                    fill="#ffffff"
                                    opacity="0.2"
                                />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">
                                Clientmate
                            </h1>
                            <p class="text-xs text-gray-600">
                                Linkedin Client Manager
                            </p>
                        </div>
                    </div>

                    <!-- Auth Links -->
                    <div
                        v-if="canLogin && !user"
                        class="flex items-center gap-3"
                    >
                        <Link
                            href="/login"
                            class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:bg-gray-100"
                        >
                            Log in
                        </Link>
                        <Link
                            v-if="canRegister"
                            href="/register"
                            class="rounded-lg bg-teal-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition-colors hover:bg-teal-700"
                        >
                            Get Started
                        </Link>
                    </div>
                    <div v-else class="flex items-center gap-3">
                        <Link
                            href="/dashboard"
                            class="flex gap-2 rounded border border-teal-200 px-4 py-2 text-sm font-medium text-teal-900 lowercase transition-colors hover:bg-teal-700 hover:text-teal-200"
                        >
                            {{ user.name }}
                            <UserRoundCog class="h-5 w-5" />
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
                <div class="grid gap-12 lg:grid-cols-2 lg:gap-16">
                    <!-- Left Content -->
                    <div class="flex flex-col justify-center">
                        <div
                            class="mb-4 inline-flex items-center gap-2 rounded-full bg-teal-100 px-4 py-2 text-sm font-medium text-teal-700"
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
                                    d="M13 10V3L4 14h7v7l9-11h-7z"
                                />
                            </svg>
                            Organize Your LinkedIn Network
                        </div>

                        <h1
                            class="mb-6 text-4xl leading-tight font-extrabold text-gray-900 sm:text-5xl lg:text-6xl"
                        >
                            Manage Your
                            <span
                                class="bg-gradient-to-r from-teal-600 to-blue-600 bg-clip-text text-transparent"
                            >
                                LinkedIn Clients
                            </span>
                            in One Place
                        </h1>

                        <p class="mb-8 text-lg leading-relaxed text-gray-600">
                            Stop losing track of your valuable LinkedIn
                            connections. Organize, categorize, and follow up
                            with your clients effortlessly. Transform your
                            LinkedIn network into a powerful relationship
                            management tool.
                        </p>

                        <!-- CTA Buttons -->
                        <div class="flex flex-wrap gap-4">
                            <Link
                                v-if="canRegister && !user"
                                href="/register"
                                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-teal-700 hover:shadow-xl"
                            >
                                Get Started Free
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
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    />
                                </svg>
                            </Link>

                            <Link
                                v-if="user"
                                href="/dashboard"
                                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-teal-700 hover:shadow-xl"
                            >
                                Dashboard
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
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    />
                                </svg>
                            </Link>

                            <Link
                                v-if="canLogin && !user"
                                href="/login"
                                class="inline-flex items-center gap-2 rounded-lg bg-teal-600 px-6 py-3 text-base font-semibold text-white shadow-lg transition-all hover:bg-teal-700 hover:shadow-xl"
                            >
                                Sign In
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
                                        d="M13 7l5 5m0 0l-5 5m5-5H6"
                                    />
                                </svg>
                            </Link>
                            <button
                                class="inline-flex items-center gap-2 rounded-lg border-2 border-gray-300 bg-white px-6 py-3 text-base font-semibold text-gray-700 transition-all hover:border-teal-600 hover:bg-gray-50"
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
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                    />
                                </svg>
                                Watch Demo
                            </button>
                        </div>

                        <!-- Stats -->
                        <div
                            class="mt-12 grid grid-cols-3 gap-6 border-t border-gray-200 pt-8"
                        >
                            <div>
                                <p class="text-3xl font-bold text-gray-900">
                                    500+
                                </p>
                                <p class="text-sm text-gray-600">
                                    Active Users
                                </p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-gray-900">
                                    10K+
                                </p>
                                <p class="text-sm text-gray-600">
                                    Clients Managed
                                </p>
                            </div>
                            <div>
                                <p class="text-3xl font-bold text-gray-900">
                                    98%
                                </p>
                                <p class="text-sm text-gray-600">
                                    Satisfaction
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Preview Image -->
                    <div class="relative">
                        <div
                            class="relative rounded-2xl bg-gradient-to-br from-teal-100 to-blue-100 p-8 shadow-2xl"
                        >
                            <!-- Mock Browser Window -->
                            <div
                                class="overflow-hidden rounded-lg bg-white shadow-xl"
                            >
                                <!-- Browser Header -->
                                <div
                                    class="flex items-center gap-2 border-b border-gray-200 bg-gray-50 px-4 py-3"
                                >
                                    <div class="flex gap-1.5">
                                        <div
                                            class="h-3 w-3 rounded-full bg-red-400"
                                        ></div>
                                        <div
                                            class="h-3 w-3 rounded-full bg-yellow-400"
                                        ></div>
                                        <div
                                            class="h-3 w-3 rounded-full bg-green-400"
                                        ></div>
                                    </div>
                                    <div
                                        class="ml-4 flex-1 rounded bg-white px-3 py-1 text-xs text-gray-500"
                                    >
                                        clientmate.com
                                    </div>
                                </div>

                                <!-- Mock Dashboard -->
                                <div class="bg-gray-50 p-6">
                                    <div
                                        class="mb-4 flex items-center justify-between"
                                    >
                                        <div
                                            class="h-6 w-40 rounded bg-gray-300"
                                        ></div>
                                        <div
                                            class="h-8 w-32 rounded bg-teal-500"
                                        ></div>
                                    </div>

                                    <!-- Mock Client Cards -->
                                    <div class="space-y-3">
                                        <div
                                            class="rounded-lg bg-white p-4 shadow-sm"
                                        >
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div
                                                    class="h-10 w-10 rounded-full bg-blue-500"
                                                ></div>
                                                <div class="flex-1">
                                                    <div
                                                        class="mb-2 h-4 w-32 rounded bg-gray-300"
                                                    ></div>
                                                    <div
                                                        class="h-3 w-24 rounded bg-gray-200"
                                                    ></div>
                                                </div>
                                                <div
                                                    class="h-6 w-16 rounded-full bg-green-100"
                                                ></div>
                                            </div>
                                        </div>
                                        <div
                                            class="rounded-lg bg-white p-4 shadow-sm"
                                        >
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div
                                                    class="h-10 w-10 rounded-full bg-purple-500"
                                                ></div>
                                                <div class="flex-1">
                                                    <div
                                                        class="mb-2 h-4 w-32 rounded bg-gray-300"
                                                    ></div>
                                                    <div
                                                        class="h-3 w-24 rounded bg-gray-200"
                                                    ></div>
                                                </div>
                                                <div
                                                    class="h-6 w-16 rounded-full bg-yellow-100"
                                                ></div>
                                            </div>
                                        </div>
                                        <div
                                            class="rounded-lg bg-white p-4 shadow-sm"
                                        >
                                            <div
                                                class="flex items-center gap-3"
                                            >
                                                <div
                                                    class="h-10 w-10 rounded-full bg-pink-500"
                                                ></div>
                                                <div class="flex-1">
                                                    <div
                                                        class="mb-2 h-4 w-32 rounded bg-gray-300"
                                                    ></div>
                                                    <div
                                                        class="h-3 w-24 rounded bg-gray-200"
                                                    ></div>
                                                </div>
                                                <div
                                                    class="h-6 w-16 rounded-full bg-red-100"
                                                ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Elements -->
                        <div
                            class="absolute -top-4 -right-4 h-24 w-24 rounded-full bg-teal-500 opacity-20 blur-2xl"
                        ></div>
                        <div
                            class="absolute -bottom-4 -left-4 h-32 w-32 rounded-full bg-blue-500 opacity-20 blur-2xl"
                        ></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="bg-white py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">
                        Everything You Need to Manage Your Network
                    </h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Powerful features to help you stay organized and
                        connected
                    </p>
                </div>

                <div class="mt-12 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-teal-100"
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
                                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Quick Bookmarking
                        </h3>
                        <p class="text-gray-600">
                            Save LinkedIn profiles with a single click. No more
                            lost connections or forgotten follow-ups.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-blue-100"
                        >
                            <svg
                                class="h-6 w-6 text-blue-600"
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
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Smart Categories
                        </h3>
                        <p class="text-gray-600">
                            Organize clients by industry, project, or any custom
                            category. Find who you need instantly.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-purple-100"
                        >
                            <svg
                                class="h-6 w-6 text-purple-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Priority Management
                        </h3>
                        <p class="text-gray-600">
                            Mark clients as high, medium, or low priority. Focus
                            on what matters most to your business.
                        </p>
                    </div>

                    <!-- Feature 4 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-green-100"
                        >
                            <svg
                                class="h-6 w-6 text-green-600"
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
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Follow-up Reminders
                        </h3>
                        <p class="text-gray-600">
                            Schedule follow-ups and never miss an important
                            conversation. Stay engaged with your network.
                        </p>
                    </div>

                    <!-- Feature 5 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100"
                        >
                            <svg
                                class="h-6 w-6 text-yellow-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Favorites System
                        </h3>
                        <p class="text-gray-600">
                            Star your most important clients for quick access.
                            Keep your VIPs at your fingertips.
                        </p>
                    </div>

                    <!-- Feature 6 -->
                    <div
                        class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition-all hover:shadow-lg"
                    >
                        <div
                            class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-lg bg-red-100"
                        >
                            <svg
                                class="h-6 w-6 text-red-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
                                />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-xl font-semibold text-gray-900">
                            Client Notes
                        </h3>
                        <p class="text-gray-600">
                            Add detailed notes about each client. Remember
                            important details for better relationships.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="bg-gradient-to-r from-teal-600 to-blue-600 py-16">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <h2 class="mb-4 text-3xl font-bold text-white sm:text-4xl">
                    Ready to Transform Your LinkedIn Network?
                </h2>
                <p class="mb-8 text-lg text-teal-100">
                    Join hundreds of professionals who are managing their
                    LinkedIn clients smarter, not harder.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <Link
                        v-if="canRegister"
                        href="/register"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-8 py-3 text-base font-semibold text-teal-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl"
                    >
                        Start Free Today
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
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />
                        </svg>
                    </Link>
                    <Link
                        v-else
                        href="/login"
                        class="inline-flex items-center gap-2 rounded-lg bg-white px-8 py-3 text-base font-semibold text-teal-600 shadow-lg transition-all hover:bg-gray-50 hover:shadow-xl"
                    >
                        Sign In Now
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
                                d="M13 7l5 5m0 0l-5 5m5-5H6"
                            />
                        </svg>
                    </Link>
                </div>
                <p class="mt-6 text-sm text-teal-100">
                    No credit card required • Free forever • Get started in 60
                    seconds
                </p>
            </div>
        </div>

        <!-- Footer -->
        <footer class="border-t border-gray-200 bg-white py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center text-sm text-gray-600">
                    <p>
                        &copy; {{ new Date().getFullYear() }} arifhassan.com.
                        All rights reserved.
                    </p>
                    <p class="mt-2">
                        Made with ❤️ for professionals who value their network
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
