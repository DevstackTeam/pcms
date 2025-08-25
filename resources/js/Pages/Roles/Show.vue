<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-shield-lock" title="Role" />

    <CardBox title="View Role">
      <div>
        <div class="row">
          <div class="col-md-6 col-lg-4 mb-3">
            <FormDetail label="Role Name">{{ role.name }}</FormDetail>
         </div>

          <div class="col-12 mb-3">
            <div class="form-label">Permissions:</div>
            <div class="row">
              <div v-for="(permissions, module) in rolePermissions" :key="module" class="col-md-4 mb-4">
                <h6 class="fw-semibold mb-2">{{ module }}</h6>
                <div class="d-flex flex-wrap gap-2">
                  <span
                    v-for="permission in permissions"
                    :key="permission"
                    class="badge bg-primary fw-medium"
                  >
                    {{ permission }}
                  </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link href="/roles" class="btn btn-outline-secondary">Close</Link>
          <Link v-if="can('Update Role') && role.name != SUPER_ADMIN" :href="`/roles/${role.id}/edit`" class="btn btn-primary ms-2">Edit</Link>
        </div>
      </div>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import FormDetail from '@/Components/FormDetail.vue'
import { can } from '@/Composables/Can'
import { Link } from '@inertiajs/vue3'

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  role: Object,
  rolePermissions: Object,
  SUPER_ADMIN: String,
})
</script>
