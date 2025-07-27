<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Campaign Detail</h1>
    <p>Details for campaign ID: {{ id }}</p>
  </div>
</template>

<script setup>
defineProps(['id', 'campaign'])
</script>
