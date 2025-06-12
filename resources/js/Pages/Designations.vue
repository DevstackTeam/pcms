<template>
  <div class="container-fluid">
    <Header iconClass="bi-people">Designation</Header>

    <CardBox title="Designation's List" :showButton="true" @button-click="showModal = true">
      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped align-middle text-center" style=" table-layout: fixed; width: 100%;">
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 10%;">No</th>
              <th scope="col" style="width: 30%;">Designation Name</th>
              <th scope="col" style="width: 30%;">Rate/Day</th>
              <th scope="col" style="width: 30%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(d, index) in designations" :key="d.id">
              <td>{{ index + 1 }}</td>
              <td style="padding: 8px 10px; text-align: left;">{{ d.name }}</td>
              <td>RM {{ d.rate_per_day }}</td>
              <td class="space-x-2">
                <a href="#" class="text-primary me-2"><i class="bi bi-pencil"></i></a>
                <a href="#" @click="confirmDelete(d.id)" class="text-danger"><i class="bi bi-trash"></i></a>
              </td>
            </tr>

            <tr v-if="designations.length === 0" >
              <td colspan="6" class="text-center text-muted">No designations found</td>
            </tr>

          </tbody>
        </table>
      </div>
    </CardBox>

    <Modal v-if="showModal" @close="showModal = false">
      <template #title>
        Create Designation
      </template>

      <template #body>
        <form @submit.prevent="submitForm">
          <div class="mb-3">
            <label class="form-label">Designation Name</label>
            <input v-model="form.name" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Rate/Day</label>
            <input v-model="form.rate_per_day" type="number" class="form-control" required min="0" />
          </div>
          <!-- Add more fields as needed -->
          <div class="d-flex justify-content-end gap-2">
            <button type="button" class="btn btn-secondary" @click="showModal = false">Cancel</button>
            <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        </form>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '../Components/Header.vue'
import CardBox from '../Components/CardBox.vue'
import Modal from '../Components/Modal.vue'
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const showModal = ref(false)

const form = useForm({
  name: '',
  rate_per_day: ''
})

const props = defineProps({
  designations: Array,
})

function confirmDelete(id) {
  if (confirm('Are you sure you want to delete this designation?')) {
    router.delete(`/designations/${id}`)
  }
}

function submitForm() {
  form.post('/designations', {
    onSuccess: () => {
      showModal.value = false
    }
  })
}

defineOptions({
  layout: SidebarLayout
})
</script>
