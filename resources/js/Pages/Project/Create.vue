<template>
  <div class="container-fluid">
    <Header iconClass="bi-kanban">Create Project</Header>

    <CardBox title="New Project">
      <form @submit.prevent="submit">
        <div class="row">
          <!-- Left side: Project Name & Description -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="name" class="form-label">Project Name</label>
              <input
                v-model="form.name"
                type="text"
                id="name"
                class="form-control"
                :class="{ 'is-invalid': form.errors.name }"
              />
              <div class="invalid-feedback">{{ form.errors.name }}</div>
            </div>

            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea
                v-model="form.description"
                id="description"
                class="form-control"
                rows="4"
                :class="{ 'is-invalid': form.errors.description }"
              ></textarea>
              <div class="invalid-feedback">{{ form.errors.description }}</div>
            </div>
          </div>

          <!-- Right side: Client & Status -->
          <div class="col-md-6">
            <div class="mb-3">
              <label for="client" class="form-label">Client</label>
              <input
                v-model="form.client"
                type="text"
                id="client"
                class="form-control"
                :class="{ 'is-invalid': form.errors.client }"
              />
              <div class="invalid-feedback">{{ form.errors.client }}</div>
            </div>

            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
              <div class="dropdown">
                <button
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
                    v-for="option in props.statusOptions"
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

const hover = ref(null)

const props = defineProps({
  statusOptions: Array
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
  form.post('/projects', {
    onSuccess: (page) => {
      // Redirect to view page with the newly created project ID
      const newProjectId = page.props.project?.id
      if (newProjectId) {
        router.visit(`/projects/${newProjectId}`)
      }
    },
  })
}
</script>

<style scoped>
.dropdown {
  position: relative;
}

.hover-primary:hover {
  background-color: #0d6efd;
}
</style>
