<template>
  <div>
    <h1>All Projects</h1>
    <ul>
      <li v-for="project in projects.data" :key="project.id">{{ project.name }}</li>
    </ul>
  </div>
</template>

<script setup>
defineProps({ projects: Object })
</script>
