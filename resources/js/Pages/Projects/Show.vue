<template>
  <div class="container-fluid px-3 px-sm-4">
    <Header iconClass="bi-file-earmark-text" title="Project" :subtitle="project.name"></Header>

    <TabLink :projectId="project.id" />

    <SuccessAlert :message="successMessage" />

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
        <Link :href="`/projects`" class="btn btn-outline-secondary">Back</Link>
        <Link v-if="can('Update Project')" :href="`/projects/${project.id}/edit`" class="btn btn-primary">Edit</Link>
      </div>
    </CardBox>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'
import TabLink from '../../Components/TabLink.vue'
import SuccessAlert from '@/Components/SuccessAlert.vue'
import { Link } from '@inertiajs/vue3'
import FormDetail from '../../Components/FormDetail.vue'
import { can } from '@/Composables/Can'
import { useFlash } from '@/Composables/Flash'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  project: Object,
  flash: Object
})

const { successMessage } = useFlash(props)
</script>
