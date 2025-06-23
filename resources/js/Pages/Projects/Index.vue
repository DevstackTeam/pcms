<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban">Project</Header>

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Project List" :showButton="true" buttonText="Add Project" @button-click="goToCreate">
      <div class="row mb-3">
        <div class="d-flex justify-content-start align-items-center gap-2">

          <input
            v-model="search"
            type="search"
            class="form-control"
            style="max-width: 300px;"
            placeholder="Search project name..."
          />

          <div class="dropdown" style="max-width: 200px; position: relative;">
            <button class="form-select text-start " style="min-width: 200px; max-width: 100%; padding: 6px 12px;" @click.prevent="isOpen = !isOpen">
              {{ props.filters.status || 'All Status' }}
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
      <table class="table table-hover table-bordered table-striped align-middle text-center" style="table-layout: fixed; width: 100%;">
        <thead class="table-light">
          <tr>
            <th scope="col" style="width: 30%;">Project Name</th>
            <th scope="col" style="width: 20%;">Total Scenarios</th>
            <th scope="col" style="width: 20%;">Status</th>
            <th scope="col" style="width: 30%;">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(project, index) in projects.data" :key="project.id">
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
              <Link :href="`/projects/${project.id}`" class="text-primary me-2"><i class="bi bi-eye me-2"></i></Link>
              <Link :href="`/projects/${project.id}/edit`" class="text-primary me-3"><i class="bi bi-pencil"></i></Link>
              <a href="#" @click.prevent="confirmDelete(project.id)" class="text-danger me-2"><i class="bi bi-trash"></i></a>
            </td>
          </tr>

          <tr v-if="projects.data.length === 0">
            <td colspan="6" class="text-center text-muted">No projects found</td>
          </tr>
        </tbody>
      </table>
    </div>
    </CardBox>
    <PaginationLink :links="projects.links" class="mt-3" />
  </div>
</template>

<script setup>
import { ref, watch, watchEffect } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import PaginationLink from '@/Components/PaginationLink.vue'
import { useFlash } from '@/Composables/Flash'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  projects: Object,
  flash: Object,
  filters: Object,
  status: Array,
})

const goToCreate = () => {
  router.visit('/projects/create')
}

const confirmDelete = (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    router.delete(`/projects/${id}`)
  }
}

const search = ref(props.filters?.search || '')
const status = ref(props.filters?.status || '')
const isOpen = ref(false)
const hover = ref(null)

const selectStatus = (selected) => {
  status.value = selected
  isOpen.value = false
}

const { successMessage } = useFlash(props)

watch(search, (newValue) => {
  router.get('/designations', { search: newValue }, {
    preserveState: true,
    replace: true
  })
})

</script>
