<template>
	<div class="mb-3 d-flex gap-2">
		<Link
			:href="route('projects.show', projectId)"
			class="btn"
			:class="isActive('details') ? 'btn-primary' : 'btn-outline-primary'">Details
		</Link>

		<Link
			:href="route('projects.scenarios.index', projectId)"
			class="btn"
			:class="isActive('scenarios') ? 'btn-primary' : 'btn-outline-primary'">Scenario
		</Link>
	</div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { route } from '../../../vendor/tightenco/ziggy/src/js';

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