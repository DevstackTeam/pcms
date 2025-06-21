<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="`${project.name} | Scenario ${scenario.id}`"></Header>

    <CardBox title="Edit Scenario">
      <form @submit.prevent="submit">
        <div class="row mb-4">
          <div class="col">
            <FormInput 
              v-model="form.duration"
              label="Duration"
              id="duration"
              placeholder="Enter Duration (in month)"
              :error="form.errors.duration"
            />
          </div>

          <div class="col">
            <FormInput 
              v-model="form.remark"
              label="Remark"
              id="remark"
              placeholder="Enter Remark"
              :error="form.errors.remark"
            />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col">
            <FormInput
              v-model="form.totalCost"
              label="Total Cost"
            />
          </div>

          <div class="col">
            <FormInput
              v-model="form.markup"
              label="Markup"
              id="markup"
              placeholder="Enter Markup (%)"
              :error="form.errors.markup"
            />
          </div>

          <div class="col">
            <FormInput
              v-model="form.finalCost"
              label="Final Cost"
              :disabled="true"
            />
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link :href="`/projects/${project.id}/scenarios`" class="btn btn-outline-secondary">Cancel</Link>
          <button type="submit" class="btn btn-primary ms-2">Save</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import { router, Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
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

const form = useForm({
  duration: props.scenario.duration,
  remark: props.scenario.remark,
  markup: props.scenario.markup,
  totalCost: props.scenario.total_cost,
  finalCost: props.scenario.final_cost,
})

const submit = () => {
  router.patch(`/projects/${props.project.id}/scenarios/${props.scenario.id}`)
}

watch(
  () => [form.totalCost, form.markup],
  ([totalCost, markup]) => {
    const cost = parseFloat(totalCost)
    const percent = parseFloat(markup)

    if (!isNaN(cost) && !isNaN(percent)) {
      form.finalCost = ((100 + percent) / 100 * cost).toFixed(2)
    } else {
      form.finalCost = null
    }
  }
)
</script>
