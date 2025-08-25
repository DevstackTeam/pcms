<template>
  <div v-if="error" class="alert alert-danger d-flex align-items-center gap-2 p-2 small mb-3">
    <i class="bi bi-exclamation-circle-fill"></i>
    <div>{{ error }}</div>
  </div>
</template>

<script setup>
defineProps({
  error: String
});
</script>
