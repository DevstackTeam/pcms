<template>
  <Head>
    <title> - Reset Password</title>
  </Head>
  <div class="d-flex align-items-center justify-content-center min-vh-100">
    <div class="card shadow-sm border-0 p-4 mx-3" style="width: 100%; max-width: 400px;">
      <div class="text-center mb-3">
        <img src="/images/pcms-logo.png" alt="Logo" style="max-width: 120px;" />
      </div>
      <h4 class="mb-3 text-center fw-bold" style="color: #525252;">Set New Password</h4>
      <p class="text-muted text-center mb-4">
        Enter your new password to reset access to your account.
      </p>

      <ErrorAlert :error="form.errors.email" />

      <form @submit.prevent="submit">
        <div class="mb-3">
          <FormDetail label="Email">
            {{ email }}
          </FormDetail>
        </div>

        <FormInput
          id="password"
          label="New Password"
          v-model="form.password"
          type="password"
          placeholder="Enter new password"
          :error="form.errors.password"
          :toggle="true"
        />

        <FormInput
          id="password_confirmation"
          label="Confirm Password"
          v-model="form.password_confirmation"
          type="password"
          placeholder="Confirm new password"
          :error="form.errors.password_confirmation"
          :toggle="true"
        />

        <button
          type="submit"
          class="btn btn-primary fw-semibold w-100 mt-3"
          :disabled="form.processing"
        >
          {{ form.processing ? 'Resetting...' : 'Reset Password' }}
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
import FormDetail from '../../Components/FormDetail.vue'
import ErrorAlert from '../../Components/ErrorAlert.vue'
import { route } from '../../../../vendor/tightenco/ziggy/src/js'

const props = defineProps({
  token: String,
  email: String,
})

const form = useForm({
  token: props.token,
  email: props.email,
  password: '',
  password_confirmation: '',
})

function submit() {
  form.post(route('password.update'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}
</script>
