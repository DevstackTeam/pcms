<template>
  <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-4">
    <div class="d-flex align-items-center">
      <!-- Icon on the left -->
      <i :class="['bi', iconClass, 'me-3 fs-1']"></i>

      <!-- Title and Subtitle stacked vertically -->
      <div>
        <h2 class="mb-0 fw-bold">{{ title }}</h2>
        <p v-if="subtitle" class="text-muted mb-0" style="font-size: 0.9rem;">
          {{ subtitle }}
        </p>
      </div>
    </div>

    <!-- Right section: User info -->
    <div class="d-flex align-items-center gap-3">
      <span class="fw-semibold">{{ user.name }}</span>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3'

defineProps({
  iconClass: String,
  title: String,
  subtitle: String,
})

const page = usePage()
const user = page.props.auth.user
</script>
