<template>
  <Head>
    <title> - Forgot Password</title>
  </Head>
  <div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0 p-4 mx-3" style="width: 100%; max-width: 400px;">
      <div class="text-center mb-3">
        <img src="/images/pcms-logo.png" alt="Logo" style="max-width: 120px;" />
      </div>

      <SuccessAlert :message="status" />

      <h4 class="mb-3 text-center fw-bold" style="color: #525252;">Reset Your Password</h4>
      <p class="text-muted text-center mb-4">
        Enter your email address and we’ll send you a link to reset your password.
      </p>

      <form @submit.prevent="submit">
        <FormInput
          id="email"
          label="Email"
          v-model="form.email"
          placeholder="Enter your email"
          :error="form.errors.email"
          :autofocus="true"
        />

        <button
          type="submit"
          class="btn btn-primary fw-semibold w-100 mt-3"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Sending...' : 'Send Reset Link' }}
        </button>
      </form>

      <div class="text-center mt-3">
        <Link :href="route('login')" class="text-decoration-none small text-muted">← Back to login</Link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, Head, Link } from '@inertiajs/vue3'
import FormInput from '../../Components/FormInput.vue'
import SuccessAlert from '@/Components/SuccessAlert.vue'
import { route } from '../../../../vendor/tightenco/ziggy/src/js'

defineProps({
  status: String,
})

const form = useForm({
  email: '',
})

function submit() {
  form.post(route('password.email'))
}
</script>
