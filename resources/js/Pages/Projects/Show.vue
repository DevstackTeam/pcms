<template>
  <div class="container-fluid">
    <Header iconClass="bi-file-earmark-text" title="Project" :subtitle="project.name"></Header>

    <TabLink :projectId="project.id" />

    <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
      {{ successMessage }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <CardBox title="Project's Details">
      <div class="row">
        <div class="col-md-6">
          <div class="mb-3">
            <FormDetail label="Project Name">
                {{ project.name }}
            </FormDetail>
          </div>

           <div class="mb-3">
            <label class="form-label" for="description">Description</label>
            <textarea
              id="description"
              class="form-control"
              rows="4"
              disabled
            >{{ project.description }}</textarea>
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <FormDetail label="Client">
                {{ project.client }}
            </FormDetail>
          </div>

          <div class="mb-3">
            <FormDetail label="Status">
                {{ project.status }}
            </FormDetail>
          </div>
        </div>
      </div>


      <div class="d-flex justify-content-end gap-2">
        <Link :href="route('projects.index')" class="btn btn-outline-secondary">Back
       </Link>
      <Link :href="route('projects.edit', project.id)" class="btn btn-primary">
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
import TabLink from '../../Components/TabLink.vue'
import { Link } from '@inertiajs/vue3'
import { usePage } from '@inertiajs/vue3'
import { ref, watchEffect } from 'vue'
import FormDetail from '../../Components/FormDetail.vue'
import { route } from '../../../../vendor/tightenco/ziggy/src/js'

defineOptions({ layout: SidebarLayout })

const successMessage = ref(null)

const props = defineProps({
  project: Object,
  flash: Object
})

watchEffect(() => {
  if (props.flash?.success) {
    successMessage.value = props.flash.success
    setTimeout(() => {
      successMessage.value = null
    }, 4000)
  }
})
</script>
