<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban">Project</Header>

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Project List" :showButton="true" buttonText="Add Project" @button-click="goToCreate">
      <div class="mb-3 d-flex justify-content-start">
        <input
          v-model="search"
          type="search"
          class="form-control"
          style="max-width: 300px;"
          placeholder="Search project name..."
        />
      </div>

     <div class="table-responsive">
  <table class="table table-hover table-bordered table-striped align-middle text-center" style=" table-layout: fixed; width: 100%;">
    <thead class="table-light">
      <tr>
        <th scope="col" style="width: 5%;">No</th>
        <th scope="col" style="width: 30%;">Project Name</th>
        <th scope="col">Total Scenarios</th>
        <th scope="col">Status</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(project, index) in projects.data" :key="project.id">
        <td>{{ projects.from + index }}</td>
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
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { router, Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  projects: Object,
  successMessage: String
})

const search = ref('')

const goToCreate = () => {
  router.visit('/projects/create')
}

const confirmDelete = (id) => {
  if (confirm('Are you sure you want to delete this project?')) {
    router.delete(`/projects/${id}`)
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString()
}
</script>
