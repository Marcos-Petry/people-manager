<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PersonForm from '@/Components/people/PersonForm.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'
import { formatCpf, formatPhone } from '@/utils/formatters'

const props = defineProps({
    person: Object,
})

const form = useForm({
    name: props.person.name ?? '',
    cpf: formatCpf(props.person.cpf ?? ''),
    type: props.person.type ?? '',
    phone: formatPhone(props.person.phone ?? ''),
    email: props.person.email ?? '',
})

const submit = () => {
    form.put(route('people.update', props.person.id))
}
</script>

<template>

    <Head title="Editar pessoa" />

    <AuthenticatedLayout>
        <div class="py-8">
            <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Editar pessoa</h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Atualize os dados da pessoa conforme necessário.
                        </p>
                    </div>

                    <Link :href="route('people.index')">
                        <SecondaryButton type="button">
                            Voltar
                        </SecondaryButton>
                    </Link>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <PersonForm :form="form" submit-label="Atualizar" @submit="submit" />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>