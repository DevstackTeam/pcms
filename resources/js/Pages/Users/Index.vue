<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-person-badge" title="Users" />

    <CardBox
      title="User List" 
      :showButton="true" 
      buttonText="Add User" 
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
              <th scope="col" style="width: 20%;">Name</th>
              <th scope="col" style="width: 60%;">Email</th>
              <th scope="col" style="width: 20%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users">
              <td style="padding: 8px 10px; text-align: left;">{{ user.name }}</td>
              <td style="padding: 8px 10px; text-align: left;">{{ user.email }}</td>
              <td class="justify-content-center">
                <Link class="text-warning me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <button class="btn p-0 text-danger" title="Delete">
                  <i class="bi bi-trash"></i>
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

defineOptions({
  layout: SidebarLayout
})
</script>
