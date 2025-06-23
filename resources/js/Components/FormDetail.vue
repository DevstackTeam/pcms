<template>
  <label class="form-label">{{ label }}</label>
  <div class="form-control bg-secondary-subtle">
    <slot />
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: "Label"
  }
})
</script>