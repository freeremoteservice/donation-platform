<script setup>
defineProps(['id', 'campaign']);
</script>

<template>
  <div class="p-6">
    <h1 class="text-3xl font-bold mb-2">{{ campaign.title }}</h1>
    <p class="mb-4">{{ campaign.description }}</p>

    <inertia-link
      :href="`/campaigns/${id}/donate`"
      class="bg-blue-600 text-white px-4 py-2 rounded"
    >
      Donate
    </inertia-link>
  </div>
</template>
