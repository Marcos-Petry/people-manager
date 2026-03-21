<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    links: Array,
    total: Number,
    currentPage: Number,
    lastPage: Number,
})

const visibleLinks = computed(() => {
    if (!props.links?.length) {
        return []
    }

    const previousLink = props.links[0]
    const nextLink = props.links[props.links.length - 1]

    const pageLinks = props.links.slice(1, -1)

    if (props.lastPage <= 7) {
        return [previousLink, ...pageLinks, nextLink]
    }

    const pagesToShow = []
    const current = props.currentPage
    const last = props.lastPage

    pageLinks.forEach((link) => {
        const page = Number(link.label)

        if (page === 1 || page === last || (page >= current - 1 && page <= current + 1)) 
        {
            pagesToShow.push(link)
        }
    })

    const result = [previousLink]
    let previousPage = null

    pagesToShow.forEach((link) => {
        const currentPage = Number(link.label)

        if (previousPage !== null && currentPage - previousPage > 1) {
            result.push({
                label: '...',
                url: null,
                active: false,
                ellipsis: true,
            })
        }

        result.push(link)
        previousPage = currentPage
    })

    result.push(nextLink)

    return result
})
</script>

<template>
    <div v-if="links && links.length"
        class="mt-4 flex flex-col items-center gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-center text-sm text-gray-500 sm:text-left">
            Página {{ currentPage }} de {{ lastPage }}
            <span class="mx-1">•</span>
            Total de registros {{ total }}
        </p>

        <div class="flex flex-wrap items-center justify-center gap-2">
            <template v-for="link in visibleLinks" :key="`${link.label}-${link.url ?? 'null'}`">
                <Link v-if="link.url && !link.ellipsis" :href="link.url"
                    class="rounded-md border px-3 py-2 text-sm transition" :class="[
                        link.active
                            ? 'border-brand bg-brand text-white'
                            : 'border-gray-300 bg-white text-gray-700 hover:border-brand hover:bg-brand-light hover:text-brand',
                    ]">
                    {{ link.label }}
                </Link>

                <span v-else
                    class="cursor-default rounded-md border border-gray-200 bg-gray-100 px-3 py-2 text-sm text-gray-400">
                    {{ link.label }}
                </span>
            </template>
        </div>
    </div>
</template>