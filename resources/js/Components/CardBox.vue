<template>
  <div class="card border shadow-sm mb-4">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-4">
        <h5 class="fw-semibold mb-0">{{ title }}</h5>
        <a 
          v-if="showButton"
          @click.prevent="$emit('button-click')"
          class="btn btn-primary btn-sm"
        >
          {{ buttonText }}
        </a>
      </div>

      <slot />
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: {
    type: String,
    default: 'Title'
  },
  showButton: {
    type: Boolean,
    default: false
  },
  buttonText: {
    type: String,
    default: '+ Create'
  },
})
</script>