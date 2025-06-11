<template>
  <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded shadow-sm mb-4">
    <h2 class="mb-0"><i :class="['bi', iconClass, 'me-2']"></i><slot /></h2>
    <div class="d-flex align-items-center gap-3">
      <span class="fw-semibold">{{ user.name }}</span>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';

defineProps({
  iconClass: {
    type: String,
  },
  userName: {
    type: String,
  },
});

const page = usePage()
const user = page.props.auth.user
</script>