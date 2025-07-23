<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-kanban" title="Projects" />

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Project List" :showButton="canCreate" buttonText="Add Project" @button-click="goToCreate">
      <div class="row mb-3">
        <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">
          <input
            id="search"
            v-model="search"
            type="search"
            class="form-control"
            style="max-width: 100%;"
            placeholder="Search project name..."
          />

          <div class="dropdown w-100 w-md-auto" style="position: relative;">
            <button
              class="form-select text-start"
              style="min-width: 100%; max-width: 100%; padding: 6px 12px;"
              @click.prevent="isOpen = !isOpen"
            >
              {{ selectedStatus || 'All Status' }}
            </button>

            <ul
              v-if="isOpen"
              class="list-group border shadow-sm mt-1"
              style="position: absolute; z-index: 1000; width: 100%"
            >
              <li
                @click="selectStatus('')"
                class="list-group-item list-group-item-action"
                style="cursor: pointer"
              >
                All Status
              </li>
              <li
                v-for="(value, key) in props.status"
                :key="key"
                @click="selectStatus(value)"
                class="list-group-item list-group-item-action"
                style="cursor: pointer"
                @mouseover="hover = key"
                @mouseleave="hover = null"
                :class="{ 'bg-primary text-white': hover === key }"
              >
                {{ value }}
              </li>
            </ul>
          </div>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-hover table-bordered table-striped align-middle text-center" style="min-width: 660px; table-layout: fixed;">
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 30%;">Project Name</th>
              <th scope="col" style="width: 20%;">Total Scenarios</th>
              <th scope="col" style="width: 20%;">Status</th>
              <th scope="col" style="width: 30%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="project in projects.data" :key="project.id">
              <td style="padding: 8px 10px; text-align: left;">{{ project.name }}</td>
              <td>{{ project.scenarios_count }}</td>
              <td>
                <span
                  class="badge"
                  :style="{
                    width: '100px',
                    backgroundColor:
                      project.status === 'Active' ? '#48C7741A' :
                      project.status === 'Completed' ? '#209CEE1A' :
                      '#FFB8001A',
                    color:
                      project.status === 'Active' ? '#48C774' :
                      project.status === 'Completed' ? '#209CEE' :
                      '#FFB800',
                  }"
                >
                  {{ project.status }}
                </span>
              </td>
              <td class="justify-content-center">
                <Link v-if="canView" :href="`/projects/${project.id}`" class="text-warning me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link v-if="canEdit" :href="`/projects/${project.id}/edit`" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <button v-if="canDelete" class="btn p-0 text-danger" @click="confirmDelete(project.id)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
            <tr v-if="projects.data.length === 0">
              <td colspan="6" class="text-center text-muted">No projects found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>

    <PaginationLink v-if="projects.data.length >= 1" :links="projects.links" class="mt-3" />
    <Modal v-if="showConfirmModal" @close="showConfirmModal = false">
      <template #title>
        Confirm Deletion
      </template>
      <template #body>
        <p>Are you sure you want to delete this project?</p>
        <div class="d-flex justify-content-end gap-2 mt-3">
          <button class="btn btn-secondary" @click="showConfirmModal = false">Cancel</button>
          <button class="btn btn-danger" @click="performDelete">Yes, Delete</button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import PaginationLink from '@/Components/PaginationLink.vue'
import Modal from '@/Components/Modal.vue'
import { useFlash } from '@/Composables/Flash'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  projects: Object,
  flash: Object,
  filters: Object,
  status: Array,
})

const page = usePage()
const canCreate = computed(() => page.props.auth.user?.permissions.includes('can_create'))
const canEdit = computed(() => page.props.auth.user?.permissions.includes('can_edit'))
const canDelete = computed(() => page.props.auth.user?.permissions.includes('can_delete'))
const canView = computed(() => page.props.auth.user?.permissions.includes('can_view'))
const search = ref(props.filters?.search || '')
const selectedStatus = ref(props.filters?.status || '')
const isOpen = ref(false)
const hover = ref(null)

const showConfirmModal = ref(false)
const confirmDeleteId = ref(null)

const goToCreate = () => {
  router.visit('/projects/create')
}

const selectStatus = (selected) => {
  selectedStatus.value = selected
  isOpen.value = false
}

function confirmDelete(id) {
  confirmDeleteId.value = id
  showConfirmModal.value = true
}

function performDelete() {
  if (!confirmDeleteId.value) return

  router.delete(`/projects/${confirmDeleteId.value}`, {
    onSuccess: () => {
      showConfirmModal.value = false
      confirmDeleteId.value = null
    }
  })
}

const { successMessage } = useFlash(props)

watch([search, selectedStatus], () => {
  router.get('/projects', {
    search: search.value,
    status: selectedStatus.value,
  }, {
    preserveState: true,
    preserveScroll: true,
  })
})
</script>
