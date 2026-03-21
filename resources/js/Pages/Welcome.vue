<script setup>
import { Head, Link } from '@inertiajs/vue3'
import AppHeader from '@/Layouts/Partials/AppHeader.vue'
import AppFooter from '@/Layouts/Partials/AppFooter.vue'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
})
</script>

<template>

    <Head title="Gerenciador de Pessoas" />

    <div class="min-h-screen flex flex-col bg-gray-50">
        <AppHeader />

        <main class="flex flex-1 items-center justify-center px-6">
            <div class="w-full max-w-2xl">
                <div class="rounded-2xl border border-gray-200 bg-white px-8 py-10 shadow-sm">
                    <h2 class="text-2xl font-semibold text-gray-900">
                        Acesse o sistema
                    </h2>

                    <p class="mt-3 text-gray-500">
                        Entre ou crie uma conta para gerenciar registros de pessoas físicas e jurídicas.
                    </p>

                    <div class="mt-6 flex gap-3">
                        <Link :href="route('login')"
                            class="rounded-md bg-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-700">
                            Entrar
                        </Link>

                        <Link v-if="canRegister" :href="route('register')"
                            class="rounded-md border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                            Registrar
                        </Link>
                    </div>
                </div>
            </div>
        </main>

        <AppFooter />
    </div>
</template>