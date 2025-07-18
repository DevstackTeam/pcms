<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project" :subtitle="project.name"></Header>

    <div v-if="form.errors.total_cost" class="alert alert-danger d-flex align-items-center gap-2 p-2 small mb-3">
      <i class="bi bi-exclamation-circle-fill"></i>
      <div>{{ form.errors.total_cost }}</div>
    </div>

    <div v-if="form.errors.manpower" class="alert alert-danger d-flex align-items-center gap-2 p-2 small mb-3">
      <i class="bi bi-exclamation-circle-fill"></i>
      <div>{{ form.errors.manpower }}</div>
    </div>

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
              <th scope="col" style="width: 5%;">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(manpower, index) in form.manpower" :key="index">
              <td>
                <v-autocomplete
                  v-model="manpower.designation_id"
                  :items="designations"
                  item-title="name"
                  item-value="id"
                  autocomplete="off"
                  label="Select Designation"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  :error="!!form.errors?.[`manpower.${index}.designation_id`]"
                  :error-messages="form.errors?.[`manpower.${index}.designation_id`] ? [form.errors[`manpower.${index}.designation_id`]] : []"
                ></v-autocomplete>
              </td>

              <td>
                <v-text-field
                  v-model="manpower.rate_per_day"
                  type="text"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  :error="!!form.errors?.[`manpower.${index}.rate_per_day`]"
                  :error-messages="form.errors?.[`manpower.${index}.rate_per_day`] ? [form.errors[`manpower.${index}.rate_per_day`]] : []"
                  @input="e => handleRateInput(e, manpower)"
                />
              </td>

              <td>
                <v-text-field
                  v-model.number="manpower.no_of_people"
                  type="number"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  :error="!!form.errors?.[`manpower.${index}.no_of_people`]"
                  :error-messages="form.errors?.[`manpower.${index}.no_of_people`] ? [form.errors[`manpower.${index}.no_of_people`]] : []"
                />
              </td>

              <td>
                <v-text-field
                  v-model.number="manpower.total_day"
                  type="number"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  :error="!!form.errors?.[`manpower.${index}.total_day`]"
                  :error-messages="form.errors?.[`manpower.${index}.total_day`] ? [form.errors[`manpower.${index}.total_day`]] : []"
                />
              </td>

              <td>
                <v-textarea
                  v-model="manpower.remark"
                  type="text"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  rows="1"
                  auto-grow
                  :error="!!form.errors?.[`manpower.${index}.remark`]"
                  :error-messages="form.errors?.[`manpower.${index}.remark`] ? [form.errors[`manpower.${index}.remark`]] : []"
                />
              </td>

              <td>{{ (manpower.total_cost || 0).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' }) }}</td>

              <td>
                <button type="button" class="btn btn-sm btn-danger" @click="removeManpower(index)">
                  <i class="bi bi-trash"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <button type="button" class="btn btn-primary mb-3" @click="addManpower">Add Manpower</button>

        <div class="row mb-3">
          <div class="col">
            <FormDetail label="Total Cost">
              {{
                form.total_cost
                  ? parseFloat(form.total_cost).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' })
                  : '-'
              }}
            </FormDetail>
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
            <FormDetail label="Final Cost">
              {{
                form.final_cost
                  ? parseFloat(form.final_cost).toLocaleString('ms-MY', { style: 'currency', currency: 'MYR' })
                  : '-'
              }}
            </FormDetail>
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
import FormDetail from '../../Components/FormDetail.vue'
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import { useSanitizeInput } from '../../Composables/Formatter'
import { useCostCalculator } from '../../Composables/Calculation'

defineOptions({
  layout: SidebarLayout,
})

const props = defineProps({
  project: Object,
  designations: Array,
})

const form = useForm({
  duration: '',
  remark: '',
  markup: null,
  total_cost: null,
  final_cost: null,
  manpower: [
    {
      designation_id: null,
      rate_per_day: null,
      no_of_people: null,
      total_day: null,
      remark: null,
      total_cost: null,
      rate_locked: false,
    },
  ],
})

const submit = () => {
  form.post(`/projects/${props.project.id}/scenarios`)
}

const addManpower = () => {
  form.manpower.push({
    designation_id: null,
    rate_per_day:null,
    no_of_people: null,
    total_day: null,
    remark: null,
    total_cost:null,
    rate_locked: false,
  })
}

const removeManpower = (index) => {
  form.manpower.splice(index, 1)
  form.clearErrors()
}

const { sanitizeDecimalInput } = useSanitizeInput()
const handleRateInput = (e, mp) => sanitizeDecimalInput(e, mp, 'rate_per_day')

useCostCalculator(form)

watch(
  () => form.manpower.map(mp => mp.designation_id),
  (newIds, oldIds) => {
    newIds.forEach((id, index) => {
      const current = form.manpower[index]

      if (id !== oldIds?.[index]) {
        const selected = props.designations.find(d => d.id === id)
        if (selected) {
          current.rate_per_day = selected.rate_per_day
          current.rate_locked = false
        }
      }
    })
  }
)
</script>
