<template>
  <div class="mb-3">
    <label :for="id" class="form-label">{{ label }}</label>

    <div :class="['input-group', { 'has-toggle': toggle }]">
      <input
        :id="id"
        :type="inputType"
        v-model="model"
        class="form-control"
        :class="{ 'is-invalid': error }"
        :placeholder="placeholder"
        :autofocus="autofocus"
      />

      <button
        v-if="toggle"
        type="button"
        class="btn btn-outline-secondary"
        @click="showPassword = !showPassword"
        tabindex="-1"
      >
        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
      </button>
    </div>

    <div v-if="error" class="invalid-feedback d-block">
      {{ error }}
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'

const model = defineModel()

const props = defineProps({
  id: {
    type: String,
    required: true
  },
  label: {
    type: String,
    required: true
  },
  type: {
    type: String,
    default: 'text'
  },
  placeholder: {
    type: String,
    default: ''
  },
  error: {
    type: String,
    default: ''
  },
  autofocus: {
    type: Boolean,
    default: false
  },
  toggle: {
    type: Boolean,
    default: false
  }
})

const showPassword = ref(false)

const inputType = computed(() => {
  return props.toggle ? (showPassword.value ? 'text' : 'password') : props.type
})
</script>