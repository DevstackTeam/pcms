<template>
  <div class="container-fluid">
    <Header iconClass="bi-people" title="Designations"></Header>

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Designation's List" :showButton="true" @button-click="showModal = true">

      <div class="mb-3 d-flex justify-content-start">
        <input
          v-model="search"
          type="search"
          class="form-control"
          style="max-width: 300px;"
          placeholder="Search designation name..."
        />
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped align-middle text-center" style=" table-layout: fixed; width: 100%;">
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 40%;">Designation Name</th>
              <th scope="col" style="width: 30%;">Rate/Day</th>
              <th scope="col" style="width: 30%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="d in props.designations.data" :key="d.id">
              <td style="padding: 8px 10px; text-align: left;">{{ d.name }}</td>
              <td>RM {{ d.rate_per_day }}</td>
              <td class="space-x-2">
                <button class="btn p-0 text-primary me-2" @click.prevent="openEditModal(d)" title="Edit">
                  <i class="bi bi-pencil"></i>
                </button>
                <button class="btn p-0 text-danger" @click="confirmDelete(d.id)" title="Delete">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>

            <tr v-if="designations.data.length === 0">
              <td colspan="6" class="text-center text-muted">No designations found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>

    <PaginationLink v-if="designations.data.length >= 1" :links="props.designations.links" />

    <Modal v-if="showModal" @close="closeModal">
      <template #title>
        {{ isEditMode ? 'Edit Designation' : 'Create Designation' }}
      </template>

      <template #body>
        <form @submit.prevent="submitForm">
          <FormInput
            label="Designation Name"
            v-model="form.name"
            type="text"
            :error="form.errors.name"
          />

          <FormInput
            label="Rate/Day"
            v-model="form.rate_per_day"
            :error="form.errors.rate_per_day"
          />

          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
            <button type="submit" class="btn btn-primary">
              {{ isEditMode ? 'Save' : 'Submit' }}
            </button>
          </div>
        </form>
      </template>
    </Modal>

    <Modal v-if="showConfirmModal" @close="showConfirmModal = false">
      <template #title>
        Confirm Deletion
      </template>
      <template #body>
        <p>Are you sure you want to delete this designation?</p>
        <div class="d-flex justify-content-end gap-2">
          <button class="btn btn-secondary" @click="showConfirmModal = false">Cancel</button>
          <button class="btn btn-danger" @click="performDelete">Yes, Delete</button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '../Components/Header.vue'
import CardBox from '../Components/CardBox.vue'
import Modal from '../Components/Modal.vue'
import PaginationLink from '../Components/PaginationLink.vue'
import FormInput from '../Components/FormInput.vue'
import { useForm, router } from '@inertiajs/vue3'
import { ref, watch } from 'vue'
import { useFlash } from '../Composables/Flash'
import { route } from '../../../vendor/tightenco/ziggy/src/js'

const search = ref('')
const showModal = ref(false)
const isEditMode = ref(false)
const editId = ref(null)
const showConfirmModal = ref(false)
const confirmDeleteId = ref(null)

const form = useForm({
  name: '',
  rate_per_day: ''
})

const props = defineProps({
  designations: Object,
  flash: Object
})

const { successMessage } = useFlash(props)

function openEditModal(designation) {
  isEditMode.value = true
  editId.value = designation.id
  form.name = designation.name
  form.rate_per_day = designation.rate_per_day
  showModal.value = true
}

function performDelete() {
  if (!confirmDeleteId.value) return

  router.delete(route('designations.destroy', confirmDeleteId.value), {
    onSuccess: () => {
      showConfirmModal.value = false
      confirmDeleteId.value = null
    }
  })
}

function confirmDelete(id) {
  confirmDeleteId.value = id
  showConfirmModal.value = true
}

function closeModal() {
  showModal.value = false
  isEditMode.value = false
  form.reset()
  form.clearErrors()
}

function submitForm() {
  if (isEditMode.value) {
    form.patch(route('designations.update', editId.value), {
      onSuccess: () => {
        closeModal()
        isEditMode.value = false
      }
    })
  } else {
  form.post(route('designations.store'), {
    onSuccess: () => {
      closeModal()
    }
  })}
}

defineOptions({
  layout: SidebarLayout
})

watch(search, (newValue) => {
  router.get(route('designations.index'), { search: newValue }, {
    preserveState: true,
    replace: true
  })
})

</script>
