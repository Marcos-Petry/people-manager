<script setup>
import { Link, router, usePage } from '@inertiajs/vue3'

const page = usePage()

const logout = () => {
    router.post(route('logout'))
}
</script>

<template>
    <header class="border-b border-gray-200 bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-4">
            <Link href="/"
                class="inline-block rounded-md transition hover:opacity-80 focus:outline-none focus:ring-2 focus:ring-indigo-500 cursor-pointer">
                <span class="block text-lg font-semibold text-gray-900 hover:text-indigo-600">
                    Gerenciador de Pessoas
                </span>

                <span class="mt-1 block text-sm text-gray-500">
                    Sistema de cadastro e manutenção de pessoas
                </span>
            </Link>

            <div v-if="page.props.auth.user" class="flex items-center gap-4">
                <span class="text-sm text-gray-600">
                    {{ page.props.auth.user.name }}
                </span>

                <button type="button" @click="logout"
                    class="rounded-md border border-gray-300 px-3 py-1.5 text-sm text-gray-700 transition hover:bg-gray-50">
                    Sair
                </button>
            </div>
        </div>
    </header>
</template>