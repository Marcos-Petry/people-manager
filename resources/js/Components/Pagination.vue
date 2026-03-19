<script setup>
import { Link } from '@inertiajs/vue3'

defineProps({
    links: Array,
    total: Number,
    currentPage: Number,
    lastPage: Number,
})

const translateLabel = (label) => {
    if (label.includes('Previous')) return 'Anterior'
    if (label.includes('Next')) return 'Próximo'

    return label
}
</script>

<template>
    <div v-if="links && links.length" class="mt-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-sm text-gray-500">
            Página {{ currentPage }} de {{ lastPage }}
            <span class="mx-1">•</span>
            Total de registros {{ total }}
        </p>

        <div class="flex flex-wrap items-center gap-2">
            <template v-for="link in links" :key="`${link.label}-${link.url}`">
                <Link v-if="link.url" :href="link.url" class="rounded-md border px-3 py-2 text-sm transition" :class="[
                    link.active
                        ? 'border-brand bg-brand text-white'
                        : 'border-gray-300 bg-white text-gray-700 hover:border-brand hover:bg-brand-light hover:text-brand',
                ]">
                    {{ translateLabel(link.label) }}
                </Link>

                <span v-else
                    class="cursor-not-allowed rounded-md border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-400">
                    {{ translateLabel(link.label) }}
                </span>
            </template>
        </div>
    </div>
</template>