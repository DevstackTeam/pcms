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
                  <h4 class="fw-bold">20</h4>
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
                  <h4 class="fw-bold">3</h4>
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
                  <h4 class="fw-bold">7</h4>
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
                  <h4 class="fw-bold">10</h4>
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
            <th scope="col">Final Cost</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example row -->
          <tr>
            <td>2</td>
            <td>Website Redesign</td>
            <td>2025-06-09</td>
            <td>RM 5000</td>
            <td><span class="badge bg-success">Active</span></td>

            <td class="d-flex gap-3">
              <a href="#" class=" btn-primary">
                <i class="bi bi-eye"></i>
              </a>
              <a href="#" class=" btn-secondary">
                <i class="bi bi-pencil"></i>
              </a>
              <a href="#" class= "btn-danger">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>

          <tr>
            <td>1</td>
            <td>Project Costing Management System</td>
            <td>2025-06-09</td>
            <td>RM 100 000</td>
            <td><span class="badge bg-secondary">Not Started</span></td>


            <td class="d-flex gap-3">
              <a href="#" class=" btn-primary">
                <i class="bi bi-eye"></i>
              </a>
              <a href="#" class=" btn-secondary">
                <i class="bi bi-pencil"></i>
              </a>
              <a href="#" class= "btn-danger">
                <i class="bi bi-trash"></i>
              </a>
            </td>
          </tr>
          <!-- Placeholder row if no data -->
          <tr>
            <td colspan="5" class="text-center text-muted">No recent projects found</td>
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
</script>
