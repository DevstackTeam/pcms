<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Dashboard</div>
          <div class="card-body">
            <h4>Welcome, {{ user.name }}!</h4>
            <p>You are logged in.</p>
            <form @submit.prevent="logout">
              <button type="submit" class="btn btn-danger">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user

const form = useForm({})
function logout() {
  form.post('/logout')
}
</script>

<style scoped>
.container { max-width: 800px; }
</style>
