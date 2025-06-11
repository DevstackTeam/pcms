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
            <h5 class="mb-4 fw-semibold">Summary</h5>

            <!-- Cards Grid -->
            <div class="row g-4">
              <!-- Card 1 -->
              <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
                  <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                      <i class="bi bi-kanban fs-2 text-primary"></i>
                    </div>
                    <div>
                      <h6 class="mb-0">Total Projects</h6>
                      <h4 class="fw-bold">{{ projectCount }}</h4>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Card 2 -->
              <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100">
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
                <div class="card shadow-sm border-0 h-100">
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
                <div class="card shadow-sm border-0 h-100">
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

        <!-- Recent Projects Card -->
        <div class="card border shadow-sm">
          <div class="card-body">
            <h5 class="mb-4 fw-semibold">Recent Projects</h5>

            <div class="table-responsive">
              <table class="table table-hover align-middle text-center">
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
                  <tr v-for="project in projects.data" :key="project.id">
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
                    <td class="d-flex justify-content-center gap-3">
                      <a href="#"><i class="bi bi-eye"></i></a>
                      <a href="#" class="text-primary"><i class="bi bi-pencil"></i></a>
                      <a href="#" class="text-danger"><i class="bi bi-trash"></i></a>
                    </td>
                  </tr>

                  <tr v-if="projects.data.length === 0">
                    <td colspan="6" class="text-center text-muted">No recent projects found</td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div v-if="projects.links" class="d-flex justify-content-center mt-4">
  <nav>
    <ul class="pagination">
      <li
        v-for="(link, index) in projects.links"
        :key="index"
        class="page-item"
        :class="{ active: link.active, disabled: !link.url }"
      >
        <Link
          class="page-link"
          :href="link.url || '#'"
          v-html="link.label"
        />
      </li>
    </ul>
  </nav>
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

user: Object,
  projects: Object,
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
