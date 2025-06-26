<template>
  <div class="col-md-6 col-xl-3">
    <div :class="`card shadow-sm border-0 h-100 ${bgColor} text-white`">
      <div class="card-body d-flex align-items-center">
        <div class="me-3">
          <i :class="`${icon} fs-2 text-white`"></i>
        </div>
        <div>
          <h6 class="mb-0">{{ title }}</h6>
          <h4 class="fw-bold">{{ count }}</h4>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  title: String,
  count: [Number, String],
  icon: String,
  bgColor: {
    type: String,
    default: 'bg-primary',
  },
});
</script>
