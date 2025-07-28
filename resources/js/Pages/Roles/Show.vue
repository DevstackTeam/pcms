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
              <div
                class="col-md-4 mb-2"
                v-for="(permission, index) in rolePermissions"
                :key="index"
              >
                <span class="badge bg-primary">{{ permission }}</span>
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link href="/roles" class="btn btn-outline-secondary">Close</Link>
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
import { Link, useForm } from '@inertiajs/vue3'

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  role: Object,
  rolePermissions: Array,
})
</script>
