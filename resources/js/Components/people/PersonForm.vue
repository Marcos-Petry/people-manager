<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { formatCpf, formatPhone } from '@/utils/formatters'

defineProps({
    form: Object,
    submitLabel: {
        type: String,
        default: 'Salvar',
    },
})

defineEmits(['submit'])
</script>

<template>
    <form @submit.prevent="$emit('submit')" class="space-y-6">
        <div>
            <InputLabel for="name" value="Nome" />

            <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" />

            <InputError class="mt-2" :message="form.errors.name" />
        </div>

        <div>
            <InputLabel for="cpf" value="CPF" />

            <TextInput id="cpf" v-model="form.cpf" type="text" class="mt-1 block w-full" placeholder="000.000.000-00"
                @input="form.cpf = formatCpf(form.cpf)" />

            <InputError class="mt-2" :message="form.errors.cpf" />
        </div>

        <div>
            <InputLabel for="type" value="Tipo" />

            <select id="type" v-model="form.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-brand focus:ring-brand">
                <option value="">Selecione</option>
                <option value="fisica">Física</option>
                <option value="juridica">Jurídica</option>
            </select>

            <InputError class="mt-2" :message="form.errors.type" />
        </div>

        <div>
            <InputLabel for="phone" value="Telefone" />

            <TextInput id="phone" v-model="form.phone" type="text" class="mt-1 block w-full"
                placeholder="(00) 00000-0000" @input="form.phone = formatPhone(form.phone)" />

            <InputError class="mt-2" :message="form.errors.phone" />
        </div>

        <div>
            <InputLabel for="email" value="E-mail" />

            <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" />

            <InputError class="mt-2" :message="form.errors.email" />
        </div>

        <div class="flex justify-end">
            <PrimaryButton :disabled="form.processing">
                {{ submitLabel }}
            </PrimaryButton>
        </div>
    </form>
</template>