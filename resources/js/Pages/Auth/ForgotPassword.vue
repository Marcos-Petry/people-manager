<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, useForm } from '@inertiajs/vue3'

defineProps({
    status: {
        type: String,
    },
})

const form = useForm({
    email: '',
})

const submit = () => {
    form.post(route('password.email'))
}
</script>

<template>
    <GuestLayout>

        <Head title="Recuperar senha" />

        <h2 class="text-2xl font-semibold text-gray-900">
            Recuperar senha
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Esqueceu sua senha? Informe seu e-mail e enviaremos um link para redefinição.
        </p>

        <div v-if="status" class="mt-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit" class="mt-6">

            <div>
                <InputLabel for="email" value="E-mail" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-6 flex items-center justify-end">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Enviar link de redefinição
                </PrimaryButton>
            </div>

        </form>

    </GuestLayout>
</template>