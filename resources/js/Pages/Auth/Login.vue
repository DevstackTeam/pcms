<template>
  <Head>
    <title> - Login</title>
  </Head>
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

        <form @submit.prevent="submit">
          <FormInput
            id="email"
            label="Email"
            v-model="form.email"
            type="text"
            placeholder="Enter your email"
            :error="form.errors.email"
            :autofocus="true"
          />

          <FormInput
            id="password"
            label="Password"
            v-model="form.password"
            type="password"
            placeholder="Enter your password"
            :error="form.errors.password"
            :toggle="true"
          />

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
  import FormInput from '../../Components/FormInput.vue'

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  })

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