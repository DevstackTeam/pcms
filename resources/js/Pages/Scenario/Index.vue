<template>
  <div class="container-fluid">
    <Header iconClass="bi-file-earmark-text" title="Project" :subtitle="project.name"></Header>

    <TabLink :projectId="project.id" />

    <CardBox title="Project's Scenario" :showButton="true" buttonText="Add Scenario" @button-click="goToCreate">
      <div class="table-responsive">
        <table 
          class="table table-hover table-bordered table-striped align-middle text-center"
          style="table-layout: fixed; width: 100%;"
        >
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 10%;">No</th>
              <th scope="col" style="width: 25%;">Duration</th>
              <th scope="col" style="width: 15%;">Markup</th>
              <th scope="col" style="width: 25%;">Final Cost</th>
              <th scope="col" style="width: 25%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(scenario, index) in scenarios" :key="scenario.id">
              <td>{{ index + 1 }}</td>
              <td>{{ scenario.duration }}</td>
              <td>{{ scenario.markup }}</td>
              <td>RM {{ scenario.final_cost }}</td>
              <td class="space-x-2">
                <Link href="#" class="text-primary me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link href="#" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <a href="#"class="text-danger me-2">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>

            <tr v-if="scenarios.length === 0">
              <td colspan="6" class="text-center text-muted">No scenarios found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>

    <CardBox title="Compare Scenarios">

    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SideBarLayout.vue';
import Header from '@/Components/Header.vue';
import CardBox from '@/Components/CardBox.vue';
import TabLink from '../../Components/TabLink.vue';
import { router, Link } from '@inertiajs/vue3';

defineOptions({
  layout: SidebarLayout
});

const goToCreate = () => {
  router.visit('/scenarios/create')
}

const props = defineProps({
  project: Object,
  scenarios: Array,
})

</script>