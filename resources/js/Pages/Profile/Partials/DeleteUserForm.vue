<script setup>
import DangerButton from '@/Components/DangerButton.vue'
import InputError from '@/Components/InputError.vue'
import InputLabel from '@/Components/InputLabel.vue'
import Modal from '@/Components/Modal.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import TextInput from '@/Components/TextInput.vue'
import { useForm } from '@inertiajs/vue3'
import { nextTick, ref } from 'vue'

const confirmingUserDeletion = ref(false)
const passwordInput = ref(null)

const form = useForm({
    password: '',
})

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true
    nextTick(() => passwordInput.value.focus())
}

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    })
}

const closeModal = () => {
    confirmingUserDeletion.value = false
    form.clearErrors()
    form.reset()
}
</script>

<template>
    <section class="space-y-6">
        <header>
            <h2 class="text-xl font-semibold text-gray-900">
                Excluir conta
            </h2>

            <p class="mt-2 text-sm text-gray-500">
                Ao excluir sua conta, todos os dados e recursos associados serão removidos permanentemente.
                Antes de continuar, recomendamos que faça o download de qualquer informação que deseja manter.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">
            Excluir conta
        </DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-semibold text-gray-900">
                    Tem certeza que deseja excluir sua conta?
                </h2>

                <p class="mt-2 text-sm text-gray-500">
                    Esta ação é permanente e não poderá ser desfeita.
                    Para confirmar, informe sua senha abaixo.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Senha" class="sr-only" />

                    <TextInput id="password" ref="passwordInput" v-model="form.password" type="password"
                        class="mt-1 block w-full" placeholder="Digite sua senha" @keyup.enter="deleteUser" />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>

                    <DangerButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        @click="deleteUser">
                        Excluir conta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>