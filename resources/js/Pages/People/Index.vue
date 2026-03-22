<script setup>
import { ref } from 'vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { EyeIcon, PencilSquareIcon, TrashIcon, PlusIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'
import DangerButton from '@/Components/DangerButton.vue'
import Modal from '@/Components/Modal.vue'
import Pagination from '@/Components/Pagination.vue'
import { formatCpf, formatPhone } from '@/utils/formatters'

const props = defineProps({
  people: Object,
  filters: {
    type: Array,
    default: () => [],
  },
})

const DEFAULT_FILTER = () => ({
  field: 'name',
  operator: 'contains',
  value: '',
})

const normalizeFilter = (filter = {}) => ({
  field: filter.field ?? 'name',
  operator: filter.operator ?? 'contains',
  value: filter.value ?? '',
})

const filterFields = [
  { value: 'name', label: 'Nome' },
  { value: 'cpf', label: 'CPF' },
  { value: 'type', label: 'Tipo' },
  { value: 'phone', label: 'Telefone' },
  { value: 'email', label: 'E-mail' },
]

const filterOperators = [
  { value: 'contains', label: 'Contém' },
  { value: 'equals', label: 'Igual a' },
  { value: 'starts_with', label: 'Começa com' },
  { value: 'ends_with', label: 'Termina com' },
]

const personToDelete = ref(null)
const isDeleting = ref(false)

const filters = ref(
  props.filters.length
    ? props.filters.map(normalizeFilter)
    : [DEFAULT_FILTER()]
)

const addFilterRow = () => {
  filters.value.push(DEFAULT_FILTER())
}

const removeFilterRow = (index) => {
  if (filters.value.length === 1) {
    filters.value = [DEFAULT_FILTER()]
    return
  }

  filters.value.splice(index, 1)
}

const applyFilters = () => {
  const validFilters = filters.value
    .map((filter) => ({
      field: filter.field ?? 'name',
      operator: filter.operator ?? 'contains',
      value: String(filter.value ?? '').trim(),
    }))
    .filter((filter) => filter.value !== '')

  const params = new URLSearchParams()

  validFilters.forEach((filter, index) => {
    params.append(`filters[${index}][field]`, filter.field)
    params.append(`filters[${index}][operator]`, filter.operator)
    params.append(`filters[${index}][value]`, filter.value)
  })

  window.location.href = `${route('people.index')}?${params.toString()}`
}

const clearFilters = () => {
  window.location.href = route('people.index')
}

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

        <!-- HEADER -->
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
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

        <div class="max-w-4xl space-y-2">
          <div v-for="(filter, index) in filters" :key="index" class="flex flex-wrap items-center gap-2">
            <select v-model="filter.field"
              class="h-8 w-full sm:w-40 rounded-md border border-gray-300 bg-white px-2 text-sm text-gray-700 outline-none focus:border-brand focus:ring-1 focus:ring-brand">
              <option v-for="field in filterFields" :key="field.value" :value="field.value">
                {{ field.label }}
              </option>
            </select>

            <select v-model="filter.operator"
              class="h-8 w-full sm:w-32 rounded-md border border-gray-300 bg-white px-2 text-sm text-gray-700 outline-none focus:border-brand focus:ring-1 focus:ring-brand">
              <option v-for="operator in filterOperators" :key="operator.value" :value="operator.value">
                {{ operator.label }}
              </option>
            </select>

            <input v-model="filter.value" type="text" placeholder="Valor"
              class="h-8 min-w-0 flex-1 rounded-md border border-gray-300 bg-white px-2 text-sm text-gray-700 outline-none focus:border-brand focus:ring-1 focus:ring-brand" />

            <button v-if="index === filters.length - 1" type="button" @click="addFilterRow"
              class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 text-gray-500 transition hover:border-brand hover:text-brand"
              title="Adicionar filtro">
              <PlusIcon class="h-4 w-4" />
            </button>

            <button type="button" @click="removeFilterRow(index)"
              class="inline-flex h-8 w-8 items-center justify-center rounded-md border border-gray-300 text-gray-500 transition hover:border-red-500 hover:text-red-500"
              title="Remover filtro">
              <XMarkIcon class="h-4 w-4" />
            </button>

            <button v-if="index === filters.length - 1" type="button" @click="applyFilters"
              class="inline-flex h-8 items-center rounded-md border border-gray-300 bg-white px-3 text-sm font-medium text-gray-600 transition hover:border-brand hover:text-brand">
              Filtrar
            </button>

            <button v-if="index === filters.length - 1" type="button" @click="clearFilters"
              class="inline-flex h-8 items-center rounded-md border border-gray-300 bg-white px-3 text-sm font-medium text-gray-600 transition hover:border-brand hover:text-brand">
              Limpar
            </button>
          </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
          <div v-if="people.data.length" class="overflow-x-auto">
            <table class="min-w-[900px] w-full divide-y divide-gray-200">
              <thead class="bg-gray-50">
                <tr>
                  <th class="table-th">Nome</th>
                  <th class="table-th">CPF</th>
                  <th class="table-th">Tipo</th>
                  <th class="table-th">Telefone</th>
                  <th class="table-th">E-mail</th>
                  <th class="table-th !text-right sticky right-0 bg-gray-50 z-10">
                    Ações
                  </th>
                </tr>
              </thead>

              <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="person in people.data" :key="person.id" class="hover:bg-gray-50">
                  <td class="table-td">
                    <div class="max-w-xs truncate" :title="person.name">
                      {{ person.name }}
                    </div>
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

                  <td
                    class="whitespace-nowrap px-6 py-4 text-right text-sm sticky right-0 bg-white shadow-[-4px_0_6px_-4px_rgba(0,0,0,0.1)]">
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