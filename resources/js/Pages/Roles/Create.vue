<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-shield-lock" title="Role" />

    <CardBox title="Create Role">
      <form @submit.prevent="submit">
        <div class="d-flex justify-content-end">
          <Link href="/roles" class="btn btn-outline-secondary">Cancel</Link>
          <button type="submit" class="btn btn-primary ms-2">Create</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import { Link } from '@inertiajs/vue3'

defineOptions({
  layout: SidebarLayout
})

defineProps({
  permissions: Array
})
</script>
