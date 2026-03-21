<script setup>
import AppHeader from '@/Layouts/Partials/AppHeader.vue'
import AppFooter from '@/Layouts/Partials/AppFooter.vue'
</script>

<template>
    <div class="flex min-h-screen flex-col bg-gray-50">

        <AppHeader />

        <main class="flex flex-1 items-center justify-center px-6 py-10">
            <div class="w-full max-w-md rounded-2xl border border-gray-200 bg-white px-8 py-8 shadow-sm">
                <slot />
            </div>
        </main>

        <AppFooter />

    </div>
</template>