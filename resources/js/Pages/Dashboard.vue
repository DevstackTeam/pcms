<template>
  <div class="container-fluid">
    <!-- Header Bar -->
    <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-4">
      <h2 class="mb-0"><i class="bi bi-house-door me-2"></i>Dashboard</h2>
      <div class="d-flex align-items-center gap-3">
        <span class="fw-semibold">{{ user.name }}</span>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <!-- Outer Card Box -->
        <div class="card border shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-semibold border-bottom pb-2 mb-4">Summary</h5>

            <!-- Cards Grid -->
            <div class="row g-4">
              <!-- Card 1 -->
              <div class="col-md-6 col-xl-3">
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                  <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                      <i class="bi bi-kanban fs-2 text-white"></i>
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
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                  <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                      <i class="bi bi-clock-history fs-2 text-white"></i>
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
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                  <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                      <i class="bi bi-bar-chart-line fs-2 text-white"></i>
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
                <div class="card shadow-sm border-0 h-100 bg-primary text-white">
                  <div class="card-body d-flex align-items-center">
                    <div class="me-3">
                      <i class="bi bi-clipboard-check fs-2 text-white"></i>
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
            <h5 class="fw-semibold border-bottom pb-2 mb-4">Recent Projects</h5>

            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped align-middle text-center" style=" table-layout: fixed; width: 100%;">
                <thead class="table-light">
                  <tr>
                    <th scope="col" style="width: 5%;">No</th>
                    <th scope="col" style="width: 30%;">Project Name</th>
                    <th scope="col">Created Date</th>
                    <th scope="col" style="width: 15%;">Total Scenarios</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="project in latestProjects" :key="project.id">
                    <td>{{ project.id }}</td>
                    <td style="padding: 8px 10px; text-align: left;">{{ project.name }}</td>
                    <td>{{ formatDate(project.created_at) }}</td>
                    <td>{{ project.scenarios_count }}</td>
                    <td>
                      <span
                        class="badge"
                        :style="{ width: '100px',
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
                    <td class=" justify-content-center">
                      <a href="#"><i class="bi bi-eye me-2"></i></a>
                      <a href="#" class="text-primary me-2"><i class="bi bi-pencil"></i></a>
                      <a href="#" class="text-danger me-2"><i class="bi bi-trash"></i></a>
                    </td>
                  </tr>

                  <tr v-if="latestProjects.length === 0">
                    <td colspan="6" class="text-center text-muted">No recent projects found</td>
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
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({
  layout: SidebarLayout
})

defineProps({

user: Object,
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
