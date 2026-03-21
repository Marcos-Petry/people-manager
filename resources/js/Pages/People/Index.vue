<script setup>
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { formatCpf, formatPhone } from '@/utils/formatters'
import Pagination from '@/Components/Pagination.vue'
import { EyeIcon, PencilSquareIcon, TrashIcon } from '@heroicons/vue/24/outline'

defineProps({
  people: Object,
})

const personToDelete = ref(null)
const isDeleting = ref(false)

const openDeleteModal = (person) => {
  personToDelete.value = person
}

const closeDeleteModal = () => {
  if (isDeleting.value) return
  personToDelete.value = null
}

const confirmDelete = () => {
  if (!personToDelete.value) return

  isDeleting.value = true

  router.delete(route('people.destroy', personToDelete.value.id), {
    onFinish: () => {
      isDeleting.value = false
      personToDelete.value = null
    },
  })
}
</script>

<template>

  <Head title="Pessoas" />

  <AuthenticatedLayout>
    <div class="py-8">
      <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
          <div>
            <h1 class="text-2xl font-semibold text-gray-900">Consulta de Pessoas</h1>
            <p class="mt-1 text-sm text-gray-500">
              Gerencie o cadastro de pessoas físicas e jurídicas.
            </p>
          </div>

          <Link :href="route('people.create')">
            <PrimaryButton>
              Cadastrar pessoa
            </PrimaryButton>
          </Link>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
          <div v-if="people.data.length" class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="table-th">
                    Nome
                  </th>
                  <th class="table-th">
                    CPF
                  </th>
                  <th class="table-th">
                    Tipo
                  </th>
                  <th class="table-th">
                    Telefone
                  </th>
                  <th class="table-th">
                    E-mail
                  </th>
                  <th class="table-th !text-right">
                    Ações
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="person in people.data" :key="person.id" class="hover:bg-gray-50">
                  <td class="table-td">
                    {{ person.name }}
                  </td>

                  <td class="table-td">
                    {{ formatCpf(person.cpf) }}
                  </td>

                  <td class="table-td">
                    {{ person.type === 'fisica' ? 'Física' : 'Jurídica' }}
                  </td>

                  <td class="table-td">
                    {{ formatPhone(person.phone) }}
                  </td>

                  <td class="table-td-email">
                    {{ person.email }}
                  </td>

                  <td class="whitespace-nowrap px-6 py-4 text-right text-sm">
                    <div class="flex justify-end gap-2">

                      <Link :href="route('people.show', person.id)"
                        class="rounded-md p-1.5 text-brand/80 transition hover:bg-brand-light hover:text-brand"
                        title="Visualizar">
                        <EyeIcon class="h-5 w-5" />
                      </Link>

                      <Link :href="route('people.edit', person.id)"
                        class="rounded-md p-1.5 text-gray-600 transition hover:bg-gray-100 hover:text-gray-900"
                        title="Editar">
                        <PencilSquareIcon class="h-5 w-5" />
                      </Link>

                      <button type="button" @click="openDeleteModal(person)"
                        class="rounded-md p-1.5 text-red-500 transition hover:bg-red-50 hover:text-red-600"
                        title="Excluir">
                        <TrashIcon class="h-5 w-5" />
                      </button>

                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div v-else class="px-6 py-12 text-center">
            <p class="text-sm text-gray-500">
              Nenhum registro encontrado
            </p>
          </div>
        </div>

        <Pagination :links="people.links" :total="people.total" :current-page="people.current_page"
          :last-page="people.last_page" />
      </div>
    </div>

    <Modal :show="!!personToDelete" @close="closeDeleteModal">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-gray-900">
          Excluir pessoa
        </h2>

        <p class="mt-2 text-sm text-gray-600">
          Tem certeza que deseja excluir
          <span class="font-medium text-gray-900">
            {{ personToDelete?.name }}
          </span>?
        </p>

        <p class="mt-2 text-sm text-gray-500">
          Esta ação não poderá ser desfeita.
        </p>

        <div class="mt-6 flex justify-end gap-3">
          <SecondaryButton @click="closeDeleteModal" :disabled="isDeleting">
            Cancelar
          </SecondaryButton>

          <DangerButton @click="confirmDelete" :disabled="isDeleting">
            Excluir pessoa
          </DangerButton>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>

<style scoped lang="postcss">
.table-th {
  @apply px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-gray-500;
}

.table-td {
  @apply whitespace-nowrap px-6 py-4 text-sm text-gray-700;
}

.table-td-email {
  @apply px-6 py-4 text-sm text-gray-700;
}
</style>