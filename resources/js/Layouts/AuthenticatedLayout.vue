<script setup>
import { ref, watch } from 'vue'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'
import NavLink from '@/Components/NavLink.vue'
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue'
import { Link, usePage } from '@inertiajs/vue3'

const showingNavigationDropdown = ref(false)

const page = usePage()

const showFlash = ref(false)
let flashTimeout = null

watch(
    () => page.props.flash?.success,
    (value) => {
        if (flashTimeout) clearTimeout(flashTimeout)

        if (value) {
            showFlash.value = true

            flashTimeout = setTimeout(() => {
                showFlash.value = false
            }, 3000)
        }
    },
    { immediate: true }
)
</script>

<template>
    <div class="min-h-screen bg-gray-100">
        <!-- NAVBAR -->
        <nav class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between">
                    <div class="flex">
                        <!-- LOGO -->
                        <div class="flex shrink-0 items-center">
                            <Link :href="route('people.index')">
                                <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800" />
                            </Link>
                        </div>

                        <!-- MENU -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <NavLink :href="route('people.index')" :active="route().current('people.*')">
                                Pessoas
                            </NavLink>
                        </div>
                    </div>

                    <!-- USER DROPDOWN -->
                    <div class="hidden sm:ms-6 sm:flex sm:items-center">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button type="button"
                                    class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 focus:outline-none">
                                    {{ $page.props.auth.user.name }}

                                    <svg class="ms-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                        fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </template>

                            <template #content>
                                <DropdownLink :href="route('profile.edit')">
                                    Perfil
                                </DropdownLink>

                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    Sair
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>

                    <!-- HAMBURGER -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ hidden: showingNavigationDropdown }" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ hidden: !showingNavigationDropdown }" stroke-linecap="round"
                                    stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- MOBILE MENU -->
            <div :class="{
                block: showingNavigationDropdown,
                hidden: !showingNavigationDropdown,
            }" class="sm:hidden">
                <ResponsiveNavLink :href="route('people.index')" :active="route().current('people.*')">
                    Pessoas
                </ResponsiveNavLink>

                <div class="border-t border-gray-200 pt-4">
                    <div class="px-4 text-sm text-gray-600">
                        {{ $page.props.auth.user.email }}
                    </div>

                    <div class="mt-3 space-y-1">
                        <ResponsiveNavLink :href="route('profile.edit')">
                            Perfil
                        </ResponsiveNavLink>

                        <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                            Sair
                        </ResponsiveNavLink>
                    </div>
                </div>
            </div>
        </nav>

        <!-- FLASH TOAST -->
        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 -translate-y-3"
            enter-to-class="opacity-100 translate-y-0" leave-active-class="transition ease-in duration-200"
            leave-from-class="opacity-100 translate-y-0" leave-to-class="opacity-0 -translate-y-3">
            <div v-if="showFlash && $page.props.flash?.success"
                class="fixed left-1/2 top-6 z-50 w-full max-w-md -translate-x-1/2 px-4">
                <div
                    class="flex items-start justify-between rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800 shadow-lg">
                    <span>{{ $page.props.flash.success }}</span>

                    <button class="ml-4 text-green-700 hover:text-green-900" @click="showFlash = false">
                        ✕
                    </button>
                </div>
            </div>
        </transition>

        <!-- PAGE CONTENT -->
        <main>
            <slot />
        </main>
    </div>
</template>