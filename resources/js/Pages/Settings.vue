<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-gear" title="Settings" />

    <div v-if="showSuccess" class="alert alert-success alert-dismissible fade show mt-3" role="alert">
      Settings saved successfully!
      <button type="button" class="btn-close" @click="showSuccess = false" aria-label="Close"></button>
    </div>

    <CardBox title="Account Details">
      <div class="border rounded shadow-sm overflow-hidden">

        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-bottom" role="button" @click="showChangePasswordModal = true">
          <div class="d-flex align-items-center">
            <i class="bi bi-lock-fill me-3 fs-5 text-primary"></i>
            <strong>Password</strong>
          </div>
          <i class="bi bi-chevron-right text-muted"></i>
        </div>

        <div class="d-flex align-items-center justify-content-between px-3 py-3 border-top" role="button" @click="showEditEmailModal = true">
          <div class="d-flex align-items-start">
            <i class="bi bi-envelope-fill fs-5 text-primary me-3 mt-1"></i>
            <div>
              <strong>Email</strong>
              <div class="text-muted small">{{ $page.props.auth.user.email }}</div>
            </div>
          </div>
          <i class="bi bi-chevron-right text-muted"></i>
        </div>
      </div>
    </CardBox>

    <CardBox title="Role">
        <p class="mb-0">
        <strong>Role:</strong>
          {{ user.name }}
        </p>
    </CardBox>

    <Modal v-if="showEditEmailModal" @close="showEditEmailModal = false">
      <template #title>Edit Email</template>
      <template #body>
        <form @submit.prevent="updateEmail">
          <div class="mb-3">
            <label for="email" class="form-label">New Email</label>
            <input type="email" v-model="emailForm.email" class="form-control" id="email" required />
            <div v-if="emailForm.errors.email" class="text-danger small mt-1">
              {{ emailForm.errors.email }}
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" @click="showEditEmailModal = false">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="emailForm.processing">
              <span v-if="emailForm.processing">Saving...</span>
              <span v-else>Save</span>
            </button>
          </div>
        </form>
      </template>
    </Modal>

    <Modal v-if="showChangePasswordModal" @close="showChangePasswordModal = false">
      <template #title>Change Password</template>
      <template #body>
        <form @submit.prevent="changePassword">
          <div class="mb-3">
            <label for="current_password" class="form-label">Current Password</label>
            <input type="password" v-model="passwordForm.current_password" class="form-control" id="current_password" required />
            <div v-if="passwordForm.errors.current_password" class="text-danger small mt-1">
              {{ passwordForm.errors.current_password }}
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" v-model="passwordForm.password" class="form-control" id="password" required />
            <div v-if="passwordForm.errors.password" class="text-danger small mt-1">
              {{ passwordForm.errors.password }}
            </div>
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" v-model="passwordForm.password_confirmation" class="form-control" id="password_confirmation" required />
            <div v-if="passwordForm.errors.password_confirmation" class="text-danger small mt-1">
              {{ passwordForm.errors.password_confirmation }}
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" @click="showChangePasswordModal = false">Cancel</button>
            <button type="submit" class="btn btn-primary" :disabled="passwordForm.processing">
              <span v-if="passwordForm.processing">Changing...</span>
              <span v-else>Change</span>
            </button>
          </div>
        </form>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import Modal from '@/Components/Modal.vue'
import { ref, watch, } from 'vue'
import { defineProps, defineOptions } from 'vue'
import { useForm } from '@inertiajs/vue3'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  auth: Object,
  errors: Object,
  user: Object
})

const showSuccess = ref(false)
const showEditEmailModal = ref(false)
const showChangePasswordModal = ref(false)
const darkMode = ref(false)

const emailForm = useForm({
  email: ''
})

function resetEmailForm() {
  emailForm.reset()
  emailForm.clearErrors()
}
watch(() => showEditEmailModal.value, (val) => {
  if (!val) {
    resetEmailForm()
  }
})

const passwordForm = useForm({
  current_password: '',
  password: '',
  password_confirmation: ''
})

function resetPasswordForm() {
  passwordForm.reset()
  passwordForm.clearErrors()
}

watch(() => showChangePasswordModal.value, (val) => {
  if (!val) {
    resetPasswordForm()
  }
})

function updateEmail() {
  emailForm.clearErrors()
  emailForm.post('/settings/email', {
    onSuccess: () => {
      showSuccess.value = true
      showEditEmailModal.value = false
      setTimeout(() => (showSuccess.value = false), 3000)
    }
  })
}

function changePassword() {
  passwordForm.clearErrors()
  passwordForm.post('/settings/password', {
    onSuccess: () => {
      showSuccess.value = true
      showChangePasswordModal.value = false
      setTimeout(() => (showSuccess.value = false), 3000)
    }
  })
}
</script>
