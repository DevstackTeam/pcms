<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <nav class="d-flex flex-column bg-light border-end vh-100 p-3" style="width: 260px; position: fixed;">
      <img src="/images/pcms-logo.png" alt="Login Image" style="max-width: 80px;" />

      <hr class="my-1" />

      <!-- Navigation Links -->
      <ul class="nav flex-column mb-auto mt-3">

        <li class="nav-item mb-2">
          <Link :href="'/dashboard'" class="nav-link" :class="isActive('/dashboard')">
            <i class="bi bi-house-door me-2"></i> Dashboard
          </Link>
        </li>

        <li class="nav-item mb-2">
          <Link :href="'/projects'" class="nav-link" :class="isActive('/projects')">
            <i class="bi bi-kanban me-2"></i> Projects
          </Link>
        </li>

        <li class="nav-item mb-2">
          <Link :href="'/roles'" class="nav-link" :class="isActive('/roles')">
            <i class="bi bi-people me-2"></i> Roles
          </Link>
        </li>

        <li class="nav-item mb-2">
          <Link :href="'/settings'" class="nav-link" :class="isActive('/settings')">
            <i class="bi bi-gear me-2"></i> Settings
          </Link>
        </li>

      </ul>

      <!-- Logout Button -->
      <form @submit.prevent="logout" class="mt-auto">
        <button type="submit" class="btn btn-secondary w-100">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </nav>

    <!-- Main content -->
    <main class="flex-grow-1 p-4" style="margin-left: 250px;">
      <slot/>
    </main>
  </div>
</template>

<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3'

const form = useForm({})
function logout() {
  form.post('/logout')
}

const page = usePage()

// Helper to check if current path is active
function isActive(path) {
  return page.url.startsWith(path)
    ? 'bg-primary-subtle text-primary rounded fw-semibold'
    : 'text-dark'
}
</script>

<style scoped>

  @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');

  * {
    font-family: 'Nunito Sans', sans-serif;
  }

</style>
