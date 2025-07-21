<template>
  <div class="d-flex">
    <!-- Sidebar -->
    <nav
      class="d-flex flex-column bg-light border-end vh-100 p-3 sidebar"
      :class="{ 'd-none d-md-flex': !isSidebarVisible }"
      style="width: 260px; position: fixed; z-index: 1030;"
    >
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
          <Link :href="'/designations'" class="nav-link" :class="isActive('/designations')">
            <i class="bi bi-people me-2"></i> Designations
          </Link>
        </li>
        <li class="nav-item mb-2">
          <Link :href="'/settings'" class="nav-link" :class="isActive('/settings')">
            <i class="bi bi-gear me-2"></i> Settings
          </Link>
        </li>
      </ul>

      <!-- Logout -->
      <form @submit.prevent="logout" class="mt-auto">
        <button type="submit" class="btn btn-secondary w-100">
          <i class="bi bi-box-arrow-right"></i> Logout
        </button>
      </form>
    </nav>

    <!-- Main Content Area -->
    <div
      class="flex-grow-1"
      :style="{
        marginLeft: isSidebarVisible || windowWidth >= 768 ? '260px' : '0px',
        transition: 'margin-left 0.3s ease'
      }"
    >
      <!-- Header -->
      <div class="p-3 border-bottom d-flex align-items-center bg-white shadow-sm" style="position: sticky; top: 0; z-index: 1020;">
        <button @click="toggleSidebar" class="btn btn-light me-3 d-md-none">
          <i class="bi bi-list fs-3"></i>
        </button>
        <h5 class="mb-0">Dashboard</h5>
      </div>

      <!-- Page content -->
      <main class="p-4">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { Link, useForm, usePage } from '@inertiajs/vue3'

const form = useForm({})
function logout() {
  form.post('/logout')
}

const page = usePage()

function isActive(path) {
  const currentPath = page.url.split('?')[0]
  return currentPath === path
    ? 'bg-primary-subtle text-primary rounded fw-semibold'
    : 'text-dark'
}

const isSidebarVisible = ref(true)
const windowWidth = ref(window.innerWidth)

function toggleSidebar() {
  isSidebarVisible.value = !isSidebarVisible.value
}

function updateWindowWidth() {
  windowWidth.value = window.innerWidth

  // Auto-show sidebar on md and above
  if (windowWidth.value >= 768) {
    isSidebarVisible.value = true
  }
}

onMounted(() => {
  window.addEventListener('resize', updateWindowWidth)
  updateWindowWidth()
})

onUnmounted(() => {
  window.removeEventListener('resize', updateWindowWidth)
})
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');

* {
  font-family: 'Nunito Sans', sans-serif;
}

.sidebar {
  transition: all 0.3s ease;
}

/* On large screens, sidebar is always visible */
@media (min-width: 768px) {
  .sidebar {
    display: flex !important;
  }
}
</style>
