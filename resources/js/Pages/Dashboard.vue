<template>
  <div class="container-fluid">
    <Header iconClass="bi-house-door" title="Dashboard"></Header>

    <div class="row">
      <div class="col-12">
        <div class="card border shadow-sm mb-4">
          <div class="card-body">
            <h5 class="fw-semibold border-bottom pb-2 mb-4">Summary</h5>
            <div class="row g-4">

              <Card
                title="Total Projects"
                :count="projectCount"
                icon="bi bi-kanban"
              />

              <Card
                title="Upcoming Projects"
                :count="notstartedCount"
                icon="bi bi-clock-history"
              />

               <Card
                title="Active Projects"
                :count="activeCount"
                icon="bi bi-bar-chart-line"
               />

              <Card
                title="Completed Projects"
                :count="completedCount"
                icon="bi bi-clipboard-check"
               />
            </div>
          </div>
        </div>
        
        <div class="card border shadow-sm">
          <div class="card-body">
            <h5 class="fw-semibold border-bottom pb-2 mb-4">Recent Projects</h5>

            <div class="table-responsive">
              <table class="table table-hover table-bordered table-striped align-middle text-center" style=" table-layout: fixed; width: 100%;">
                <thead class="table-light">
                  <tr>
                    <th scope="col" style="width: 40%;">Project Name</th>
                    <th scope="col" style="width: 25%;">Created Date</th>
                    <th scope="col" style="width: 20%;">Total Scenarios</th>
                    <th scope="col" style="width: 15%;">Status</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="project in latestProjects" :key="project.id">
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
                  </tr>

                  <tr v-if="latestProjects.length === 0">
                    <td colspan="6" class="text-center text-muted">No recent projects found</td>
                  </tr>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '../Components/Header.vue'
import Card from '../Components/Card.vue'

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
