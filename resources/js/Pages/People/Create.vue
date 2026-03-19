<script setup>
import PersonForm from '@/Components/people/PersonForm.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    cpf: '',
    type: 'fisica',
    phone: '',
    email: '',
})

const submit = () => {
    form.post(route('people.store'))
}
</script>

<template>

    <Head title="Cadastrar pessoa" />

    <AuthenticatedLayout>
        <div class="py-8">
            <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Cadastrar pessoa</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Preencha os dados para adicionar uma nova pessoa ao sistema.
                        </p>
                    </div>

                    <Link :href="route('people.index')">
                        <SecondaryButton type="button">
                            Voltar
                        </SecondaryButton>
                    </Link>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <PersonForm :form="form" @submit="submit" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>