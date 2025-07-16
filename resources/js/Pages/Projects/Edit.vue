<template>
  <div class="container-fluid">
    <Header
      iconClass="bi-pencil-square" title="Project" :subtitle="project.name"></Header>

    <CardBox title="Edit Project">
      <form @submit.prevent="submit">
        <div class="row">
          <div class="col-md-6">
            <FormInput
              id="project-name"
              label="Project Name"
              type="text"
              v-model="form.name"
              :error="form.errors.name"
            />

            <label for="description" class="form-label">Description</label>
            <textarea
              id="description"
              class="form-control"
              rows="4"
              v-model="form.description"
            ></textarea>
            <div v-if="form.errors.description" class="text-danger small">
              {{ form.errors.description }}
            </div>
          </div>

          <div class="col-md-6">
            <FormInput
              id="client"
              label="Client"
              type="text"
              v-model="form.client"
              :error="form.errors.client"
            />

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <div class="dropdown">
                <button
                  id="status"
                  class="form-select text-start"
                  @click.prevent="isOpen = !isOpen"
                >
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

        <div class="d-flex justify-content-end gap-2">
       <Link :href="`/projects/${project.id}`" class="btn btn-outline-secondary">Cancel
       </Link><button type="submit" class="btn btn-primary">Save</button>
      </div>

      </form>
    </CardBox>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3'
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import { Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import FormInput from '../../Components/FormInput.vue'

const hover = ref(null)
const isOpen = ref(false)

defineOptions({
    layout: SidebarLayout
})

const props = defineProps({
  project: Object,
  status: Array,
})

const selectOption = (option) => {
  form.status = option
  isOpen.value = false
}

const form = useForm({
  name: props.project.name,
  description: props.project.description,
  client: props.project.client,
  status: props.project.status,
})

const submit = () => {
  form.patch(`/projects/${props.project.id}`)
}

</script>
