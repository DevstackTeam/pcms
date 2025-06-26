<template>
  <div class="container-fluid">
    <Header iconClass="bi-file-earmark-text" title="Project" :subtitle="project.name"></Header>

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <TabLink :projectId="project.id" />

    <CardBox title="Project's Scenario" :showButton="true" buttonText="Add Scenario" @button-click="goToCreate">
      <div class="table-responsive">
        <table 
          class="table table-hover table-bordered table-striped align-middle text-center"
          style="table-layout: fixed; width: 100%;"
        >
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 7%;">No</th>
              <th scope="col" style="width: 15%;">Duration</th>
              <th scope="col" style="width: 15%;">Markup</th>
              <th scope="col" style="width: 24%;">Total Cost</th>
              <th scope="col" style="width: 24%;">Final Cost</th>
              <th scope="col" style="width: 15%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="scenario in scenarios" :key="scenario.id">
              <td>{{ scenario.id }}</td>
              <td>{{ scenario.duration }} {{ scenario.duration == 1 ? 'Month' : 'Months' }}</td>
              <td>{{ scenario.markup }}%</td>

              <td class="text-center">
                <div class="d-inline-block text-start" style="width: 150px;">
                  {{ 
                    parseFloat(scenario.total_cost).toLocaleString('ms-MY', {
                      style: 'currency',
                      currency: 'MYR'
                    }) 
                  }}
                </div>
              </td>

              <td class="text-center">
                <div class="d-inline-block text-start" style="width: 150px;">
                  {{
                    parseFloat(scenario.final_cost).toLocaleString('ms-MY', {
                      style: 'currency',
                      currency: 'MYR'
                    })
                  }}
                </div>
              </td>

              <td class="space-x-2">
                <Link :href='`/projects/${project.id}/scenarios/${scenario.id}`' class="text-primary me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>

                <Link :href='`/projects/${project.id}/scenarios/${scenario.id}/edit`' class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>

                <button 
                  type="button" 
                  class="btn btn-link text-danger p-0" 
                  title="Delete" 
                  @click="confirmDelete(scenario.id)"
                >
                  <i class="bi bi-trash"></i>
                </button>
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
                  <td>
                    {{ 
                      parseFloat(selectedScenario1.total_cost).toLocaleString('ms-MY', { 
                        style: 'currency', 
                        currency: 'MYR' 
                      }) 
                    }}</td>
                  <td>
                    {{ 
                      parseFloat(selectedScenario2.total_cost).toLocaleString('ms-MY', { 
                        style: 'currency', 
                        currency: 'MYR' }) 
                    }}
                  </td>
                </tr>
                <tr>
                  <td>Mark Up</td>
                  <td>{{ selectedScenario1.markup }}%</td>
                  <td>{{ selectedScenario2.markup }}%</td>
                </tr>
                <tr>
                  <td>Final Cost</td>

                  <td :class="finalCostClass(selectedScenario1.final_cost, selectedScenario2.final_cost)">
                    {{ 
                      parseFloat(selectedScenario1.final_cost).toLocaleString('ms-MY', { 
                        style: 'currency', 
                        currency: 'MYR' 
                      }) 
                    }}
                  </td>
                  
                  <td :class="finalCostClass(selectedScenario2.final_cost, selectedScenario1.final_cost)">
                    {{ 
                      parseFloat(selectedScenario2.final_cost).toLocaleString('ms-MY', { 
                        style: 'currency', 
                        currency: 'MYR' 
                      }) 
                    }}
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

    <Modal v-if="showConfirmModal" @close="showConfirmModal = false">
      <template #title>
        Confirm Deletion
      </template>
      <template #body>
        <p>Are you sure you want to delete this scenario?</p>
        <div class="d-flex justify-content-end gap-2">
          <button class="btn btn-secondary" @click="showConfirmModal = false">Cancel</button>
          <button class="btn btn-danger" @click="performDelete">Yes, Delete</button>
        </div>
      </template>
    </Modal>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SideBarLayout.vue';
import Header from '@/Components/Header.vue';
import CardBox from '@/Components/CardBox.vue';
import TabLink from '../../Components/TabLink.vue';
import Modal from '../../Components/Modal.vue';
import { useFlash } from '../../Composables/Flash';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineOptions({
  layout: SidebarLayout
});

const selectedScenario1 = ref(null)
const selectedScenario2 = ref(null)
const confirmDeleteId = ref(null)
const showConfirmModal = ref(false)

const props = defineProps({
  project: Object,
  scenarios: Array,
  flash: Object,
})

const { successMessage } = useFlash(props)

const goToCreate = () => {
  router.get(`/projects/${props.project.id}/scenarios/create`)
}

const finalCostClass = (costA, costB) => {
  if (costA < costB) return 'text-success fw-bold';
  if (costA > costB) return 'text-danger fw-bold';
  return '';
};

function confirmDelete(id) {
  confirmDeleteId.value = id
  showConfirmModal.value = true
}

function performDelete() {
  if (!confirmDeleteId.value) return

  router.delete(`/projects/${props.project.id}/scenarios/${confirmDeleteId.value}`, {
    onSuccess: () => {
      showConfirmModal.value = false
      confirmDeleteId.value = null
    }
  })
}
</script>
