<template>
	<div class="mb-3 d-flex gap-2">
		<Link
			:href="`/projects/${projectId}`"
			class="btn"
			:class="isActive('details') ? 'btn-primary' : 'btn-outline-primary'">Details
		</Link>

		<Link
			:href="`/projects/${projectId}/scenarios`"
			class="btn"
			:class="isActive('scenarios') ? 'btn-primary' : 'btn-outline-primary'">Scenario
		</Link>
	</div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';

const props = defineProps({
	projectId: {
    type: Number,
  },
})

const page = usePage()

const isActive = (tab) => {
  const currentPath = page.url

  if (tab === 'details') {
    return currentPath === `/projects/${props.projectId}`
  }

  if (tab === 'scenarios') {
    return currentPath.startsWith(`/projects/${props.projectId}/scenarios`)
  }

  return false
}
</script>