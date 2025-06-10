<template>
  <div class="container-fluid">
    <h2 class="mb-4">Dashboard</h2>

    <!-- Outer Card Box -->
    <div class="card border shadow-sm">
      <div class="card-body">

        <h5 class="mb-4 fw-semibold">Summary</h5>

        <!-- Cards Grid -->
        <div class="row g-4">
          <!-- Card 1 -->
          <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i class="bi bi-kanban fs-2 text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0"> Total Projects</h6>
                  <h4 class="fw-bold">{{ projectCount }}</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i class="bi bi-clock-history fs-2 text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0">Upcoming Projects</h6>
                  <h4 class="fw-bold">{{ notstartedCount }}</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i class="bi bi-bar-chart-line fs-2 text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0">Active Projects</h6>
                  <h4 class="fw-bold">{{ activeCount }}</h4>
                </div>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="col-md-6 col-xl-3">
            <div class="card shadow-sm border-0">
              <div class="card-body d-flex align-items-center">
                <div class="me-3">
                  <i class="bi bi-clipboard-check fs-2 text-primary"></i>
                </div>
                <div>
                  <h6 class="mb-0">Completed Projects</h6>
                  <h4 class="fw-bold">{{ completedCount }}</h4>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- End of Cards Grid -->
      </div>
    </div>
    <!-- End of Outer Card Box -->
  </div>

  <div class="card border shadow-sm mt-5">
    <div class="card-body">
      <h5 class="mb-4 fw-semibold">Recent Projects</h5>

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
  <tr v-for="project in projects" :key="project.id">
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
        {{ project.status }}
      </span>
    </td>
    <td class="d-flex gap-3">
      <a href="#" class="">
        <i class="bi bi-eye"></i>
      </a>
      <a href="#" class="text-primary">
        <i class="bi bi-pencil"></i>
      </a>
      <a href="#" class="text-danger">
        <i class="bi bi-trash"></i>
      </a>
    </td>
  </tr>

  <tr v-if="projects.length === 0">
    <td colspan="6" class="text-center text-muted">No recent projects found</td>
  </tr>
</tbody>

      </table>
    </div>
  </div>
</div>

</template>


<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({
  layout: SidebarLayout
})

defineProps({
  projects: Array,
  projectCount: Number,
  activeCount: Number,
  completedCount: Number,
  notstartedCount: Number
});

function formatDate(date) {
  return new Date(date).toISOString().split('T')[0];}
</script>

<style scoped>
  bg-success {
    background-color: #FFB800;
  }
</style>
