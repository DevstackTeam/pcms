<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div v-if="errors.email" class="alert alert-danger">
              <ul class="mb-0">
                <li v-for="(error, i) in errors.email" :key="i">{{ error }}</li>
              </ul>
            </div>
            <form @submit.prevent="submit">
              <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input v-model="form.email" type="email" class="form-control" id="email" required autofocus />
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input v-model="form.password" type="password" class="form-control" id="password" required />
              </div>
              <div class="mb-3 form-check">
                <input v-model="form.remember" type="checkbox" class="form-check-input" id="remember" />
                <label class="form-check-label" for="remember">Remember me</label>
              </div>
              <button type="submit" class="btn btn-primary w-100" :disabled="form.processing">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
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
.container { max-width: 600px; }
</style>
