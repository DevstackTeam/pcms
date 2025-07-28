<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-person-badge" title="Users" />

    <CardBox title="View User">
      <div class="row">
        <div class="col-md-6 mb-3">
          <FormDetail label="Name">
            {{ user.name }}
          </FormDetail>
        </div>

        <div class="col-md-6 mb-3">
          <FormDetail label="Email">
            {{ user.email }}
          </FormDetail>
        </div>

        <div class="col-md-6 mb-3">
          <FormDetail label="Username">
            {{ user.username }}
          </FormDetail>
        </div>
      </div>

      <div class="d-flex justify-content-end">
        <Link href="/users" class="btn btn-outline-secondary">Close</Link>
        <Link :href="`/users/${user.id}/edit`" class="btn btn-primary ms-2">Edit</Link>
      </div>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue';
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import FormDetail from '@/Components/FormDetail.vue'
import { Link } from '@inertiajs/vue3';

defineOptions({
  layout: SidebarLayout
})

const props = defineProps({
  user: Object
})
</script>
