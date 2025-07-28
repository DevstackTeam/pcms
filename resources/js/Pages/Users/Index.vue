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
              <th scope="col" style="width: 30%;">Name</th>
              <th scope="col" style="width: 20%;">Email</th>
              <th scope="col" style="width: 30%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
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
