<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban" title="Project"></Header>

    <CardBox title="Create New Project">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-md-6">
            <div class="mb-3">
              <FormInput
                v-model="form.name"
                label="Project Name"
                id="name"
                :error="form.errors.name"
              />
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea
                v-model="form.description"
                id="description"
                class="form-control"
                rows="4"
              ></textarea>
              <div v-if="form.errors.description" class="text-danger small">{{ form.errors.description }}</div>
            </div>
          </div>

          <div class="col-md-6">
            <div class="mb-3">
              <FormInput
                v-model="form.client"
                label="Client"
                id="client"
                :error="form.errors.client"
              />
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <div class="dropdown">
                <button
                  class="form-select text-start"
                  @click.prevent="isOpen = !isOpen">
                  {{ form.status || 'Select status' }}
                </button>

                <ul
                  v-if="isOpen"
                  class="list-group border shadow-sm mt-1"
                  style="position: absolute; z-index: 1000; width: 100%"
                >
                  <li
                    v-for="option in props.status"
                    :key="option"
                    @click="selectOption(option)"
                    class="list-group-item list-group-item-action"
                    style="cursor: pointer"
                    @mouseover="hover = option"
                    @mouseleave="hover = null"
                    :class="{ 'bg-primary text-white': hover === option }"
                    >
                    {{ option }}
                </li>
                </ul>
              </div>
              <div v-if="form.errors.status" class="text-danger small">{{ form.errors.status }}</div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">Create</button>
        </div>
      </form>
    </CardBox>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useForm, router } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import FormInput from '../../Components/FormInput.vue'

const hover = ref(null)

const props = defineProps({
  status: Array
})

defineOptions({ layout: SidebarLayout })

const isOpen = ref(false)

const form = useForm({
  name: '',
  description: '',
  client: '',
  status: ''
})

const selectOption = (option) => {
  form.status = option
  isOpen.value = false
}

const submit = () => {
  form.post('/projects')
}
</script>

<style scoped>
.dropdown {
  position: relative;
}
</style>
