<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-shield-lock" title="Roles" />

    <SuccessAlert :message="successMessage" />

    <CardBox
      title="Role's List"
      :showButton="can('Create Role')"
      buttonText="Add Role"
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
              <th scope="col" style="width: 25%;">Role Name</th>
              <th scope="col" style="width: 50%;">Permission</th>
              <th 
                v-if="can('View Role') || can('Update Role') || can('Delete Role')" 
                scope="col" 
                style="width: 25%;"
              >
                Action
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles">
              <td style="padding: 8px 10px; text-align: left;">{{ role.name }}</td>

              <td class="text-start">
                <span
                  v-for="permission in role.permissions"
                  class="badge bg-primary me-1"
                >
                  {{ permission.name }}
                </span>
              </td>

              <td
                v-if="can('View Role') || can('Update Role') || can('Delete Role')" 
                class="justify-content-center"
              >
                <Link v-if="can('View Role')" :href="`/roles/${role.id}`" class="text-warning me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link v-if="can('Update Role') && role.name != SUPER_ADMIN" :href="`/roles/${role.id}/edit`" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <button v-if="can('Delete Role') && role.name != SUPER_ADMIN" @click="confirmDelete(role.id)">
                  <i class="bi bi-trash text-danger"></i>
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
        <p>Are you sure you want to delete this role?</p>
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
import { router, Link } from '@inertiajs/vue3'
import { ref } from 'vue'

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  roles: Array,
  flash: Object,
  SUPER_ADMIN: String,
})

const confirmDeleteId = ref(null)
const showConfirmModal = ref(false)
const { successMessage } = useFlash(props)

const goToCreate = () => {
  router.get('/roles/create')
}

function confirmDelete(id) {
  confirmDeleteId.value = id
  showConfirmModal.value = true
}

function performDelete() {
  if (!confirmDeleteId.value) return

  router.delete(`/roles/${confirmDeleteId.value}`, {
    onSuccess: () => {
      showConfirmModal.value = false
      confirmDeleteId.value = null
    }
  })
}
</script>
