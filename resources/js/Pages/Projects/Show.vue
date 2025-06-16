<template>
  <div class="container-fluid">
    <Header iconClass="bi-eye">Project Details</Header>

    <CardBox title="View Project">
      <div class="row">
        <!-- Left side: Project Name & Description -->
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

        <!-- Right side: Client & Status -->
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
    </CardBox>
  </div>
</template>

<script setup>
import Header from '@/Components/Header.vue'
import CardBox from '@/Components/CardBox.vue'
import SidebarLayout from '@/Layouts/SidebarLayout.vue'

defineOptions({ layout: SidebarLayout })

const props = defineProps({
  project: Object
})
</script>
