<template>
  <div class="container-fluid">
    <!-- Header Bar -->
    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-4">
      <h2 class="mb-0"><i class="bi bi-house-door me-2"></i>Dashboard</h2>
      <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold">{{ user.name }}</span>
        <span class="badge bg-secondary text-capitalize">{{ user.role }}</span>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Outer Card Box -->
        <div class="card border shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-semibold border-bottom pb-2 mb-4">Summary</h5>

      <div class="table-responsive">
        <table class="table table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th scope="col">#</th>
              <th scope="col">Project Name</th>
            <th scope="col">Created Date</th>
            <th scope="col">Total Scenarios</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
  <tr v-for="project in latestProjects" :key="project.id">
    <td>{{ project.id }}</td>
    <td>{{ project.name }}</td>
    <td>{{ formatDate(project.created_at) }}</td>
    <td>{{ project.scenarios_count }}</td>
    <td>
      <span
        class="badge"
    :style="{
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
        <Link
          class="page-link"
          :href="link.url || '#'"
          v-html="link.label"
        />
      </span>
    </td>
  </tr>
</tbody>
</table>
</div>
</div>
</div>
<!-- End Recent Projects Card -->
</div>
</div>
</div>
</template>



<script setup>
import { Link } from '@inertiajs/vue3'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({
  layout: SidebarLayout
})

defineProps({
  projects: Array,
  latestProjects: Array,
  projectCount: Number,
  activeCount: Number,
  completedCount: Number,
  notstartedCount: Number
});

function formatDate(date) {
  return new Date(date).toISOString().split('T')[0];}
</script>

<style scoped>

  @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');

  * {
    font-family: 'Nunito Sans', sans-serif;
  }

  .bg-success {
    background-color: #FFB800;
  }
</style>
