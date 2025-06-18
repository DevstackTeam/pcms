<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban">Create Scenario</Header>

    <CardBox title="Create Scenario">
      <form @submit.prevent="submit">
        <div class="row mb-4">
          <div class="col">
            <label>Duration</label>
            <input type="text" v-model="form.duration" class="form-control" placeholder="Enter duration (in month)" />
          </div>
          <div class="col">
            <label>Remark</label>
            <input type="text" v-model="form.remark" class="form-control" placeholder="Enter remark" />
          </div>
        </div>

        <!-- Manpower Table -->
        <h5>Manpower</h5>
        <table class="table table-bordered text-center">
          <thead>
            <tr>
              <th>Role</th>
              <th>No. of People</th>
              <th>Total Day</th>
              <th>Cost</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(manpower, index) in form.manpowers" :key="index">
              <td><input v-model="manpower.role" class="form-control" /></td>
              <td><input v-model.number="manpower.people" type="number" class="form-control" /></td>
              <td><input v-model.number="manpower.days" type="number" class="form-control" /></td>
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

        <!-- Totals -->
        <div class="row mb-3">
          <div class="col">
            <label>Total Cost</label>
            <input type="text" class="form-control" :value="`RM ${totalCost.toLocaleString()}`" disabled />
          </div>
          <div class="col">
            <label>Markup (%)</label>
            <input type="number" v-model.number="form.markup" class="form-control" />
          </div>
          <div class="col">
            <label>Final Cost</label>
            <input type="text" class="form-control" :value="`RM ${finalCost.toLocaleString()}`" disabled />
          </div>
        </div>

        <button type="submit" class="btn btn-success">Save Scenario</button>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import { reactive, computed } from 'vue'
import { router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({
  layout: SidebarLayout,
})

const form = reactive({
  duration: '',
  remark: '',
  markup: 0,
  manpowers: [],
})

const calculateCost = (mp) => (mp.people || 0) * (mp.days || 0) * 100

const totalCost = computed(() =>
  form.manpowers.reduce((sum, mp) => sum + calculateCost(mp), 0)
)

const finalCost = computed(() =>
  totalCost.value + (totalCost.value * form.markup) / 100
)

const addManpower = () => {
  form.manpowers.push({ role: '', people: 1, days: 1 })
}

const removeManpower = (index) => {
  form.manpowers.splice(index, 1)
}

const submit = () => {
  router.post('/scenarios', {
    ...form,
    total_cost: totalCost.value,
    final_cost: finalCost.value,
  })
}
</script>
