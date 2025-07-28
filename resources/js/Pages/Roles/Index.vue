<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-shield-lock" title="Roles" />

    <CardBox
      title="Role's List"
      :showButton="true"
      buttonText="Add Role"
      @button-click="goToCreate"
    >
      <div class="table-responsive">
        <table 
          class="table table-hover table-bordered table-striped align-middle text-center" 
          style="min-width: 660px; 
          table-layout: fixed;"
        >
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 25%;">Role Name</th>
              <th scope="col" style="width: 50%;">Permission</th>
              <th scope="col" style="width: 25%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="role in roles">
              <td style="padding: 8px 10px; text-align: left;">{{ role.name }}</td>

              <td>

              </td>

              <td class="justify-content-center">
                <Link :href="`/roles/${role.id}`" class="text-warning me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link :href="`/roles/${role.id}/edit`" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <button >
                  <i class="bi bi-trash text-danger"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import { router, Link } from '@inertiajs/vue3'

defineOptions({
  layout: SidebarLayout
})

defineProps({
  roles: Array
})

const goToCreate = () => {
  router.get('/roles/create')
}
</script>
