<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-shield-lock" title="Role" />

    <CardBox title="Create Role">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-3">
            <FormInput
              id="role-name"
              label="Role Name"
              v-model="form.name"
              type="text"
              :error="form.errors.name"
            />
          </div>

          <div class="col-12 mb-3">
            <div class="form-label">Permissions:</div>
            <div class="row">
              <div v-for="(actions, module) in permissions" :key="module" class="col-md-4 mb-4">
                <h6 class="fw-semibold mb-2">{{ module }}</h6>

                <div v-for="(label, permission) in actions" :key="permission" class="form-check mb-2">
                  <input
                    :id="`permission-${permission}`"
                    class="form-check-input"
                    type="checkbox"
                    :value="permission"
                    v-model="form.permissions"
                  />
                  <label
                    :for="`permission-${permission}`"
                    class="form-check-label"
                  >
                    {{ label }}
                  </label>
                </div>
              </div>
            </div>
          </div>

          <div v-if="form.errors.permissions" class="text-danger mt-1">
            {{ form.errors.permissions }}
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link :href="route('roles.index')" class="btn btn-outline-secondary">Cancel</Link>
          <button v-if="can('Create Role')" type="submit" class="btn btn-primary ms-2">Create</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import FormInput from '@/Components/FormInput.vue'
import { can } from '@/Composables/Can'
import { Link, useForm } from '@inertiajs/vue3'
import { route } from '../../../../vendor/tightenco/ziggy/src/js'

defineOptions({
  layout: SidebarLayout
})

defineProps({
  permissions: Object
})

const form = useForm({
  name: '',
  permissions: []
})

const submit = () => {
  form.post(route('roles.store'))
}
</script>
