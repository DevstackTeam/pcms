<template>
  <div class="container-fluid">
    <Header iconClass="bi-file-earmark-text">Project<p class="text-muted ms-5 mt-2" style="font-size: 0.9rem;">test</p>
    </Header>

    <TabLink :projectId="project.id" />

    <CardBox title="Project's Scenario" :showButton="true">
      <div class="table-responsive">
        <table 
          class="table table-hover table-bordered table-striped align-middle text-center"
          style="table-layout: fixed; width: 100%;"
        >
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 25%;">Duration</th>
              <th scope="col" style="width: 25%;">Markup</th>
              <th scope="col" style="width: 25%;">Final Cost</th>
              <th scope="col" style="width: 25%;">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 8px 10px; text-align: left;"></td>
              <td></td>
              <td></td>
              <td class="space-x-2">
                <Link href="#" class="text-primary me-2">
                  <i class="bi bi-eye me-2"></i>
                </Link>
                <Link href="#" class="text-primary me-3">
                  <i class="bi bi-pencil"></i>
                </Link>
                <a href="#"class="text-danger me-2">
                  <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>

            <tr>
              <td colspan="6" class="text-center text-muted">No designations found</td>
            </tr>
          </tbody>
        </table>
      </div>
    </CardBox>
  </div>
</template>

<script setup>
import SidebarLayout from '@/Layouts/SideBarLayout.vue';
import Header from '@/Components/Header.vue';
import CardBox from '@/Components/CardBox.vue';
import TabLink from '../../Components/TabLink.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({
  layout: SidebarLayout
});

const props = defineProps({
  project: Object,
  scenarios: Array,
})

</script>