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

        <h6>Manpower</h6>
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th scope="col" style="width: 25%;">Designation</th>
              <th scope="col" style="width: 15%;">Rate/Day</th>
              <th scope="col" style="width: 15%;">No. of People</th>
              <th scope="col" style="width: 15%;">Total Day</th>
              <th scope="col" style="width: 25%;">Cost</th>
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
                  label="Select Designation"
                  variant="outlined"
                  density="compact"
                  hide-details="auto"
                  :error="!!form.errors?.[`manpower.${index}.designation_id`]"
                  :error-messages="form.errors?.[`manpower.${index}.designation_id`] ? 
                    [form.errors[`manpower.${index}.designation_id`]] : []"
                ></v-autocomplete>
              </td>

              <td><input v-model="manpower.rate_per_day" class="form-control" @input="() => manpower.rate_locked = true"></td>
              <td><input v-model.number="manpower.no_of_people" type="number" class="form-control" /></td>
              <td><input v-model.number="manpower.total_day" type="number" class="form-control" /></td>
              <td>RM {{ calculateCost(manpower).toLocaleString() }}</td>
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
            <FormDetail label="Total Cost" id="total-cost">
              {{ parseFloat(form.total_cost).toLocaleString('ms-MY', { 
                  style: 'currency', 
                  currency: 'MYR' 
                })
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
            <FormDetail label="Final Cost" id="final-cost">
              {{ parseFloat(form.final_cost).toLocaleString('ms-MY', { 
                  style: 'currency', 
                  currency: 'MYR' 
                })  
              }}
            </FormDetail>
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
import { Link, useForm } from '@inertiajs/vue3'
import { watch } from 'vue'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import FormInput from '../../Components/FormInput.vue'
import FormDetail from '../../Components/FormDetail.vue'

defineOptions({
  layout: SidebarLayout,
})

const props = defineProps({
  project: Object,
  scenario: Object,
  manpowers: Object,
  designations: Array,
})

const form = useForm({
  duration: props.scenario.duration,
  remark: props.scenario.remark,
  markup: props.scenario.markup,
  total_cost: props.scenario.total_cost,
  final_cost: props.scenario.final_cost,
  
  manpower: props.manpowers.map(mp => ({
    designation_id: mp.designation_id,
    rate_per_day: mp.rate_per_day,
    no_of_people: mp.no_of_people,
    total_day: mp.total_day,
    total_cost: mp.total_cost,
    rate_locked: false,
  })),
})

const submit = () => {
  form.patch(`/projects/${props.project.id}/scenarios/${props.scenario.id}`)
}

const addManpower = () => {
  form.manpower.push({ 
    designation_id: null, 
    rate_per_day:null, 
    no_of_people: null, 
    total_day: null, 
    total_cost:null,
    rate_locked: false,
  })
}

const removeManpower = (index) => {
  form.manpower.splice(index, 1)
}

const calculateCost = (mp) => (mp.no_of_people || 0) * (mp.total_day || 0) * (mp.rate_per_day || 0)

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

watch(
  () => form.manpower.map(mp => mp.designation_id),
  (newIds, oldIds) => {
    newIds.forEach((id, index) => {
      const selected = props.designations.find(d => d.id === id)
      const current = form.manpower[index]
      if (id !== oldIds?.[index] && selected) {
        current.rate_per_day = selected.rate_per_day
        current.rate_locked = false
      }
    })
  }
)

watch(
  () => form.manpower,
  () => {
    let total = 0

    form.manpower.forEach((mp) => {
      const cost = calculateCost(mp)
      mp.total_cost = parseFloat(cost.toFixed(2))
      total += cost
    })

    form.total_cost = total.toFixed(2)
  },
  { deep: true }
)
</script>
