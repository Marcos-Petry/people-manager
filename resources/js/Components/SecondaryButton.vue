<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-widest text-gray-700 transition duration-150 ease-in-out hover:border-brand hover:bg-brand-light hover:text-brand focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2">
        <slot />
    </button>
</template>
