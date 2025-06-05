<template>
  <div class="d-flex min-vh-100">
    <!-- Left Panel - Add width and display properties -->
    <div class="bg-primary d-none d-lg-flex" style="flex: 1;">
      <div class="d-flex align-items-center justify-content-center text-white h-100 w-100">
        <h2>Your Brand</h2>
      </div>
    </div>

    <!-- Right Panel - Add width and centering -->
    <div class="d-flex align-items-center justify-content-center" style="flex: 1; min-width: 400px;">
      <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 400px;">
        <h4 class="mb-3 text-center fw-bold">Login to your Account</h4>

        <div v-if="errors.email || errors.password" class="alert alert-danger">
          <ul class="mb-0">
            <li v-for="(errorList, key) in errors" :key="key">
              <span v-for="(error, i) in errorList" :key="i">{{ error }}</span>
            </li>
          </ul>
        </div>

        <form @submit.prevent="submit">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="form-control"
              id="email"
              placeholder="Enter your email"
              required
              autofocus
            />
          </div>

          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                class="form-control"
                id="password"
                placeholder="Enter your password"
                required
              />
              <button
                type="button"
                class="btn btn-outline-secondary"
                @click="togglePassword"
                tabindex="-1"
              >
                <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
              </button>
            </div>
          </div>

          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
              <input
                v-model="form.remember"
                class="form-check-input"
                type="checkbox"
                id="remember"
              />
              <label class="form-check-label" for="remember">
                Remember Me
              </label>
            </div>
            <a href="#" class="text-decoration-none small text-muted">Forgot Password?</a>
          </div>

          <button
            type="submit"
            class="btn btn-primary fw-semibold w-100"
            :disabled="form.processing"
          >
            {{ form.processing ? 'Logging in...' : 'Login' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
  import { reactive } from 'vue'
  import { useForm, usePage } from '@inertiajs/vue3'
  import { ref } from 'vue'

  const page = usePage()
  const errors = page.props.errors || {}
  const showPassword = ref(false)

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  })

  function togglePassword() {
    showPassword.value = !showPassword.value
  }

  function submit() {
    form.post('/login')
  }
</script>

<style scoped>
  @import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap');
  
  * {
    font-family: 'Nunito Sans', sans-serif;
  }

  body {
    background-color: #f8f9fa;
  }
</style>