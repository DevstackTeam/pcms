<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="`${project.name} | Scenario ${scenario.id}`"></Header>

    <CardBox title="Scenario's Detail">
      <form>
        <div class="row mb-4">
          <div class="col">
            <FormDetail label="Duration">
              {{ scenario.duration }} {{ scenario.duration == 1 ? 'Month' : 'Months' }}
            </FormDetail>
          </div>

          <div class="col">
            <FormDetail label="Remark">
              {{ scenario.remark }}
            </FormDetail>
          </div>
        </div>

        <h6>Manpower</h6>
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th scope="col" style="width: 25%;">Designation</th>
              <th scope="col" style="width: 13%;">Rate/Day</th>
              <th scope="col" style="width: 15%;">No. of People</th>
              <th scope="col" style="width: 12%;">Total Day</th>
              <th scope="col" style="width: 15%;">Remark</th>
              <th scope="col" style="width: 15%;">Cost</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(manpower, index) in manpowers" :key="index">
              <td>{{ manpower.designation.name }}</td>
              <td>
                {{ parseFloat(manpower.rate_per_day).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' }) }}</td>
              <td>{{ manpower.no_of_people }}</td>
              <td>{{ manpower.total_day }}</td>
              <td style="text-align: left;">{{ manpower.remark }}</td>
              <td>{{ parseFloat(manpower.total_cost).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' }) }}</td>
            </tr>
          </tbody>
        </table>

        <div class="row mb-3">
          <div class="col">
            <FormDetail label="Total Cost">
              {{ parseFloat(scenario.total_cost).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' }) }}
            </FormDetail>
          </div>

          <div class="col">
            <FormDetail label="Markup">
              {{ scenario.markup }}%
            </FormDetail>
          </div>
          
          <div class="col">
            <FormDetail label="Final Cost">
              {{ parseFloat(scenario.final_cost).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' }) }}
            </FormDetail>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link :href="`/projects/${project.id}/scenarios`" class="btn btn-outline-secondary">Close</Link>
          <Link :href="`/projects/${project.id}/scenarios/${scenario.id}/edit`" class="btn btn-primary ms-2">Edit</Link>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import FormDetail from '../../Components/FormDetail.vue'

defineOptions({
  layout: SidebarLayout,
})

const props = defineProps({
  project: Object,
  scenario: Object,
  manpowers: Object,
})
</script>
