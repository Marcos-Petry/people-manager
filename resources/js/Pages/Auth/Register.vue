<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Head, Link, useForm } from '@inertiajs/vue3'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout>

        <Head title="Registrar" />

        <h2 class="text-2xl font-semibold text-gray-900">
            Criar conta
        </h2>

        <p class="mt-2 text-sm text-gray-500">
            Preencha os dados abaixo para acessar o sistema de gerenciamento de pessoas.
        </p>

        <form @submit.prevent="submit" class="mt-6">

            <div>
                <InputLabel for="name" value="Nome" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="E-mail" />

                <TextInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Senha" />

                <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirmar senha" />

                <TextInput id="password_confirmation" type="password" class="mt-1 block w-full"
                    v-model="form.password_confirmation" required />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-6 flex items-center justify-between">
                <Link :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Já possui conta?
                </Link>

                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Registrar
                </PrimaryButton>
            </div>

        </form>
    </GuestLayout>
</template>