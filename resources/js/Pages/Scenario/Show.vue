<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="`${project.name} | Scenario ${scenario.id}`"></Header>

    <CardBox title="Scenario's Detail">
      <form>
        <div class="row mb-4">
          <div class="col">
            <FormInput 
              v-model="scenario.duration"
              label="Duration"
              :disabled="true"
              />
          </div>

          <div class="col">
            <FormInput 
              v-model="scenario.remark"
              label="Remark"
              :disabled="true"
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <FormInput
              v-model="scenario.total_cost"
              label="Total Cost"
              :disabled="true"
            />
          </div>

          <div class="col">
            <FormInput
              v-model="scenario.markup"
              label="Markup"
              :disabled="true"
            />
          </div>
          
          <div class="col">
            <FormInput
              v-model="scenario.final_cost"
              label="Final Cost"
              :disabled="true"
            />
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
import FormInput from '../../Components/FormInput.vue'

defineOptions({
  layout: SidebarLayout,
})

const props = defineProps({
  project: Object,
  scenario: Object,
})
</script>
