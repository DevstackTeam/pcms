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
            <tr v-for="scenario in scenarios" :key="scenario.id">
              <td>{{ scenario.id }}</td>
              <td>{{ scenario.duration }} Month</td>
              <td>{{ scenario.markup }}%</td>
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
      <template v-if="scenarios.length >= 2">
        <div class="row justify-content-center mb-4">
          <div class="col-md-4 text-center">
            <select v-model="selectedScenario1" class="form-select">
              <option disabled value="">Select Scenario 1</option>
              <option v-for="scenario in scenarios" :key="scenario.id" :value="scenario">
                {{ scenario.name || 'Scenario ' + scenario.id }}
              </option>
            </select>
          </div>
          <div class="col-md-1 text-center fw-bold align-self-center">vs</div>
          <div class="col-md-4 text-center">
            <select v-model="selectedScenario2" class="form-select">
              <option disabled value="">Select Scenario 2</option>
              <option v-for="scenario in scenarios" :key="scenario.id + '-2'" :value="scenario">
                {{ scenario.name || 'Scenario ' + scenario.id }}
              </option>
            </select>
          </div>
        </div>

        <div v-if="selectedScenario1 && selectedScenario2">
          <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
              <thead class="table-dark">
                <tr>
                  <th></th>
                  <th>{{ selectedScenario1.name || 'Scenario 1' }}</th>
                  <th>{{ selectedScenario2.name || 'Scenario 2' }}</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Duration</td>
                  <td>{{ selectedScenario1.duration }}</td>
                  <td>{{ selectedScenario2.duration }}</td>
                </tr>
                <tr>
                  <td>Total Cost</td>
                  <td>RM {{ selectedScenario1.total_cost }}</td>
                  <td>RM {{ selectedScenario2.total_cost }}</td>
                </tr>
                <tr>
                  <td>Mark Up</td>
                  <td>{{ selectedScenario1.markup }}%</td>
                  <td>{{ selectedScenario2.markup }}%</td>
                </tr>
                <tr>
                  <td>Final Cost</td>
                  <td :class="finalCostClass(selectedScenario1.final_cost, selectedScenario2.final_cost)">
                    RM {{ selectedScenario1.final_cost }}
                  </td>
                  <td :class="finalCostClass(selectedScenario2.final_cost, selectedScenario1.final_cost)">
                    RM {{ selectedScenario2.final_cost }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div v-else class="text-muted text-center">
          Please select two scenarios to compare.
        </div>
      </template>

      <template v-else>
        <div class="text-muted text-center">
          You need at least two scenarios to perform a comparison.
        </div>
      </template>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SideBarLayout.vue';
import Header from '@/Components/Header.vue';
import CardBox from '@/Components/CardBox.vue';
import TabLink from '../../Components/TabLink.vue';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
  layout: SidebarLayout
});

const selectedScenario1 = ref(null);
const selectedScenario2 = ref(null);

const goToCreate = () => {
  router.visit('/scenarios/create')
}

const props = defineProps({
  project: Object,
  scenarios: Array,
})

const finalCostClass = (costA, costB) => {
  if (costA < costB) return 'text-success fw-bold';
  if (costA > costB) return 'text-danger fw-bold';
  return '';
};
</script>