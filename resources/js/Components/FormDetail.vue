<template>
  <label :for="id" class="form-label">{{ label }}</label>
  <div :id="id" class="form-control bg-secondary-subtle">
    <slot />
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: "Label"
  },
  id: {
    type: String,
    default: ''
  }
})
</script>