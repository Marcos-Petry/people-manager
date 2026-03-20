<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import { Head, Link } from '@inertiajs/vue3'
import { formatCpf, formatPhone } from '@/utils/formatters'

defineProps({
    person: Object,
})
</script>

<template>

    <Head title="Visualizar pessoa" />

    <AuthenticatedLayout>
        <div class="py-8">
            <div class="mx-auto max-w-3xl space-y-6 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">
                            Visualizar pessoa
                        </h1>
                        <p class="mt-1 text-sm text-gray-500">
                            Detalhes da pessoa.
                        </p>
                    </div>

                    <Link :href="route('people.index')">
                        <SecondaryButton type="button">
                            Voltar
                        </SecondaryButton>
                    </Link>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="space-y-6">
                        <div class="field-group">
                            <span class="field-label">Nome</span>
                            <div class="field-value">
                                {{ person.name }}
                            </div>
                        </div>

                        <div class="field-group">
                            <span class="field-label">CPF</span>
                            <div class="field-value">
                                {{ formatCpf(person.cpf) }}
                            </div>
                        </div>

                        <div class="field-group">
                            <span class="field-label">Tipo</span>
                            <div class="field-value">
                                {{ person.type === 'fisica' ? 'Física' : 'Jurídica' }}
                            </div>
                        </div>

                        <div class="field-group">
                            <span class="field-label">Telefone</span>
                            <div class="field-value">
                                {{ formatPhone(person.phone) }}
                            </div>
                        </div>

                        <div class="field-group">
                            <span class="field-label">E-mail</span>
                            <div class="field-value">
                                {{ person.email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped lang="postcss">
.field-group {
    @apply space-y-1;
}

.field-label {
    @apply block text-sm font-medium text-gray-700;
}

.field-value {
    @apply mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2 text-sm text-gray-900;
}
</style>