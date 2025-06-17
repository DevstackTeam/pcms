<!-- resources/js/Components/PaginationLinks.vue -->
<template>
  <nav>
    <ul class="pagination">
      <li
        v-for="link in links"
        :key="link.label"
        :class="{ active: link.active, disabled: !link.url }"
        class="page-item"
      >
        <Link
          class="page-link"
          :href="link.url"
          v-html="link.label"
          preserve-scroll
          preserve-state
        />
      </li>
    </ul>
  </nav>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
const props = defineProps({
  links: {
    type: Array,
    required: true
  }
})
</script>
