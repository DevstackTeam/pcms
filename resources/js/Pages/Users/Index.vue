<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-person-badge" title="Users" />

    <SuccessAlert :message="successMessage" />

    <CardBox
      title="User List" 
      :showButton="can('create-user')" 
      buttonText="Add User" 
      @button-click="goToCreate"
    >
      <div class="table-responsive">
        <table 
          class="table table-hover table-bordered table-striped align-middle text-center" 
          style="min-width: 660px; 
          table-layout: fixed;"
        >
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 20%;">Name</th>
              <th scope="col" style="width: 30%;">Email</th>
              <th scope="col" style="width: 30%;">Role</th>
              <th 
                v-if="can('view-user') || can('edit-user') || can('delete-user')"
                scope="col" 
                style="width: 20%;"
              >
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users">
              <td style="padding: 8px 10px; text-align: left;">{{ user.name }}</td>
              <td style="padding: 8px 10px; text-align: left;">{{ user.email }}</td>
              <td>
                <span
                  v-for="role in user.roles"
                  class="badge bg-primary me-1"
                >
                  {{ role.name }}
                </span>
              </td>
              <td
                v-if="can('view-user') || can('edit-user') || can('delete-user')" 
                class="justify-content-center"
              >
                <Link v-if="can('view-user')" :href="`/users/${user.id}`" class="text-warning me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link v-if="can('edit-user')" :href="`/users/${user.id}/edit`" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <button v-if="can('delete-user')" class="btn p-0 text-danger" title="Delete" @click="confirmDelete(user.id)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>

    <Modal v-if="showConfirmModal" @close="showConfirmModal = false">
      <template #title>
        Confirm Deletion
      </template>
      <template #body>
        <p>Are you sure you want to delete this user?</p>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button class="btn btn-secondary" @click="showConfirmModal = false">Cancel</button>
          <button class="btn btn-danger" @click="performDelete">Yes, Delete</button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import Modal from '@/Components/Modal.vue'
import SuccessAlert from '@/Components/SuccessAlert.vue'
import { can } from '@/Composables/Can'
import { useFlash } from '@/Composables/Flash'
import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  users: Array,
  flash: Object,
})

const confirmDeleteId = ref(null)
const showConfirmModal = ref(false)
const { successMessage } = useFlash(props)

const goToCreate = () => {
  router.get('/users/create')
}

function confirmDelete(id) {
  confirmDeleteId.value = id
  showConfirmModal.value = true
}

function performDelete() {
  if (!confirmDeleteId.value) return

  router.delete(`/users/${confirmDeleteId.value}`, {
    onSuccess: () => {
      showConfirmModal.value = false
      confirmDeleteId.value = null
    }
  })
}
</script>
