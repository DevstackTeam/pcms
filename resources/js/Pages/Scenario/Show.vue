<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="`${project.name} | Scenario ${scenario.id}`"></Header>

    <CardBox title="Scenario's Detail">
      <form>
        <div class="row mb-4">
          <div class="col">
            <FormDetail label="Duration">
              {{ scenario.duration }}
            </FormDetail>
          </div>

          <div class="col">
            <FormDetail label="Remark">
              {{ scenario.remark }}
            </FormDetail>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <FormDetail label="Total Cost">
              {{ scenario.total_cost }}
            </FormDetail>
          </div>

          <div class="col">
            <FormDetail label="Markup">
              {{ scenario.markup }}
            </FormDetail>
          </div>
          
          <div class="col">
            <FormDetail label="Final Cost">
              {{ scenario.final_cost }}
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
})
</script>
