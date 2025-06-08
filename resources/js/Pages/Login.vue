<template>
  <div class="d-flex min-vh-100">
    <!-- Left Panel - Add width and display properties -->
    <div class="bg-primary d-none d-lg-flex" style="flex: 1;">
      <div class="d-flex align-items-center justify-content-center text-white h-100 w-100">
        <img src="/images/costing-pic.svg" alt="Login Illustration" style="max-width: 60%; height: auto;" />
      </div>
    </div>

    <!-- Right Panel - Add width and centering -->
    <div class="d-flex align-items-center justify-content-center" style="flex: 1; min-width: 400px;">
      <div class="card shadow-sm border-0 p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-3">
          <img src="/images/pcms-logo.png" alt="Login Image" style="max-width: 120px;" />
        </div>
        <h4 class="mb-3 text-center fw-bold" style="color: #525252;">Login to your Account</h4>

        <!-- Display form errors using form.errors -->
        <div v-if="form.errors.email || form.errors.password" class="alert alert-danger">
          <ul class="mb-0">
            <li v-if="form.errors.email">{{ form.errors.email }}</li>
            <li v-if="form.errors.password">{{ form.errors.password }}</li>
          </ul>
        </div>

        <form @submit.prevent="submit">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
              v-model="form.email"
              type="email"
              class="form-control"
              :class="{ 'is-invalid': form.errors.email }"
              id="email"
              placeholder="Enter your email"
              autofocus
            />
            <div v-if="form.errors.email" class="invalid-feedback">
              {{ form.errors.email }}
            </div>
          </div>

          <div class="mb-3 position-relative">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input
                :type="showPassword ? 'text' : 'password'"
                v-model="form.password"
                class="form-control"
                :class="{ 'is-invalid': form.errors.password }"
                id="password"
                placeholder="Enter your password"
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
            <div v-if="form.errors.password" class="invalid-feedback d-block">
              {{ form.errors.password }}
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
  import { useForm } from '@inertiajs/vue3'
  import { ref } from 'vue'

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