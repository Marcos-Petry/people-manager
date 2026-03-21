<script setup>
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
})

const user = usePage().props.auth.user

const form = useForm({
    name: user.name,
    email: user.email,
})
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-xl font-semibold text-gray-900">
                Informações do perfil
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Atualize seu nome e endereço de e-mail de acesso à conta.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6">
            <div>
                <InputLabel for="name" value="Nome" />

                <TextInput id="name" v-model="form.name" type="text" class="mt-1 block w-full" required autofocus
                    autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="E-mail" />

                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required
                    autocomplete="username" />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm text-gray-600">
                    Seu endereço de e-mail ainda não foi verificado.
                    <Link :href="route('verification.send')" method="post" as="button"
                        class="font-medium text-brand underline transition hover:text-brand/80 focus:outline-none">
                        Clique aqui para reenviar o e-mail de verificação.
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'" class="text-sm font-medium text-green-600">
                    Um novo link de verificação foi enviado para o seu e-mail.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">
                    Salvar
                </PrimaryButton>

                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-500">
                        Informações atualizadas com sucesso.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>