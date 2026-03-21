<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import { Head } from '@inertiajs/vue3'

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
})
</script>

<template>

    <Head title="Perfil" />

    <AuthenticatedLayout>
        <div class="py-10">
            <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-900">Perfil</h1>
                    <p class="mt-2 text-sm text-gray-500">
                        Gerencie suas informações de acesso e segurança da conta.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-8 xl:grid-cols-2">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <UpdateProfileInformationForm :must-verify-email="mustVerifyEmail" :status="status"
                            class="max-w-none" />
                    </div>

                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        <UpdatePasswordForm class="max-w-none" />
                    </div>
                </div>

                <div class="mx-auto max-w-3xl rounded-xl border border-red-100 bg-white p-6 shadow-sm sm:p-8">
                    <DeleteUserForm class="max-w-none" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>