<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-person-badge" title="Users" />

    <CardBox title="Edit User">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-md-6">
            <FormInput
              v-model="form.name"
              label="Name"
              id="name"
              :error="form.errors.name"
            />
          </div>

          <div class="col-md-6">
            <FormInput
              v-model="form.email"
              label="Email"
              id="email"
              type="email"
              :error="form.errors.email"
            />
          </div>

          <div class="col-md-6">
            <FormInput
              v-model="form.username"
              label="Username"
              id="username"
              :error="form.errors.username"
            />
          </div>

          <div class="col-md-6">
            <FormInput
              v-model="form.password"
              label="Password"
              id="password"
              type="password"
              :toggle="true"
              :error="form.errors.password"
            />
          </div>
        </div>

        <div class="col-12 mb-3">
          <div class="form-label">Roles:</div>
          <div class="col">
            <div
              class="col-md-4"
              v-for="role in roles"
              :key="role.id"
            >
              <div class="form-check">
                <input
                  :id="`role-${role}`"
                  class="form-check-input"
                  type="checkbox"
                  :value="role"
                  v-model="form.roles"
                />
                <label
                  :for="`role-${role}`"
                  class="form-check-label"
                >
                  {{ role }}
                </label>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link href="/users" class="btn btn-outline-secondary">Cancel</Link>
          <button type="submit" class="btn btn-primary ms-2">Save</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import FormInput from '@/Components/FormInput.vue'
import { useForm, Link } from '@inertiajs/vue3';

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  user: Object,
  roles: Array,
  userRoles: Array,
})

const form = useForm({
  name: props.user.name,
  email: props.user.email,
  username: props.user.username,
  password: '',
  roles: props.userRoles || [],
})

const submit = () => {
  form.patch(`/users/${props.user.id}`)
}
</script>
