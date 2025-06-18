<template>
  <div class="container-fluid">
    <Header
      iconClass="bi-file-earmark-text">Project Details
        <p class="text-muted ms-5 mt-2" style="font-size: 0.9rem;">{{ project.name }}</p>
    </Header>

    <div class="mb-3 d-flex gap-2">
      <Link
        :href="`/projects/${project.id}`"
        class="btn"
        :class="isActive('details') ? 'btn-primary' : 'btn-outline-primary'">Details
      </Link>

      <Link
        :href="`/projects/${project.id}/scenarios`"
        class="btn"
        :class="isActive('scenarios') ? 'btn-secondary' : 'btn-outline-secondary'">Scenario
      </Link>
    </div>

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Project's Details">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Project Name</label>
            <input
              type="text"
              class="form-control"
              :value="project.name"
              disabled
            />
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea
              class="form-control"
              rows="4"
              :value="project.description"
              disabled
            ></textarea>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Client</label>
            <input
              type="text"
              class="form-control"
              :value="project.client"
              disabled
            />
          </div>

          <div class="mb-3">
            <label class="form-label">Status</label>
            <input
              type="text"
              class="form-control"
              :value="project.status"
              disabled
            />
          </div>
        </div>
      </div>


      <div class="d-flex justify-content-end gap-2">
        <Link :href="`/projects`" class="btn btn-outline-secondary">Back
       </Link>
      <Link :href="`/projects/${project.id}/edit`" class="btn btn-primary">
      Edit
    </Link>
    </div>
    </CardBox>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { ref, watchEffect } from 'vue'

defineOptions({ layout: SidebarLayout })

const successMessage = ref(null)

const props = defineProps({
  project: Object,
  flash: Object
})

const page = usePage()

const isActive = (tab) => {
  const currentPath = page.url

  if (tab === 'details') {
    return currentPath === `/projects/${props.project.id}`
  }

  if (tab === 'scenarios') {
    return currentPath.startsWith(`/projects/${props.project.id}/scenarios`)
  }

  return false
}

watchEffect(() => {
  if (props.flash?.success) {
    successMessage.value = props.flash.success
    setTimeout(() => {
      successMessage.value = null
    }, 4000)
  }
})
</script>
