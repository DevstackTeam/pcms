<template>
  <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow rounded-4 border-0">
        <div class="card-body p-4">
          <h3 class="text-center mb-4">Welcome Back 👋</h3>

          <div v-if="errors.email || errors.password" class="alert alert-danger">
            <ul class="mb-0">
              <li v-for="(error, i) in errors.email" :key="'email-' + i">{{ error }}</li>
              <li v-for="(error, i) in errors.password" :key="'password-' + i">{{ error }}</li>
            </ul>
          </div>

          <form @submit.prevent="submit">
            <div class="form-floating mb-3">
              <input v-model="form.email" type="email" class="form-control" id="email" placeholder="name@example.com" required autofocus />
              <label for="email">Email address</label>
            </div>

            <div class="form-floating mb-3">
              <input v-model="form.password" type="password" class="form-control" id="password" placeholder="Password" required />
              <label for="password">Password</label>
            </div>

            <div class="form-check mb-3">
              <input v-model="form.remember" type="checkbox" class="form-check-input" id="remember" />
              <label class="form-check-label" for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn btn-primary w-100 rounded-pill" :disabled="form.processing">
              {{ form.processing ? 'Logging in...' : 'Login' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'

const page = usePage()
const errors = page.props.errors || {}

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
body {
  background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
}

.card {
  background-color: #ffffff;
}
</style>
