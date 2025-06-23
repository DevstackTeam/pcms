<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="project.name"></Header>

    <CardBox title="Create Scenario">
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
              v-model="form.total_cost"
              label="Total Cost"
              id="total_cost"
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
              v-model="form.final_cost"
              label="Final Cost"
              id="final_cost"
              :disabled="true"
            />
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <Link :href="`/projects/${project.id}/scenarios`" class="btn btn-outline-secondary">Cancel</Link>
          <button type="submit" class="btn btn-primary ms-2">Submit</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import FormInput from '../../Components/FormInput.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'

defineOptions({
  layout: SidebarLayout,
})

const props = defineProps({
  project: Object,
})

const form = useForm({
  duration: '',
  remark: '',
  markup: null,
  total_cost: null,
  final_cost: null,
})

const submit = () => {
  form.post(`/projects/${props.project.id}/scenarios`)
}

watch(
  () => [form.total_cost, form.markup],
  ([total_cost, markup]) => {
    const cost = parseFloat(total_cost)
    const percent = parseFloat(markup)

    if (!isNaN(cost) && !isNaN(percent)) {
      form.final_cost = ((100 + percent) / 100 * cost).toFixed(2)
    } else {
      form.final_cost = null
    }
  }
)
</script>
