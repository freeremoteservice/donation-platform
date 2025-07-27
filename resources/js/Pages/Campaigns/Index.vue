<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">All Campaigns</h1>
  
      <div v-if="campaigns.length">
        <div v-for="campaign in campaigns" :key="campaign.id" class="p-4 mb-4 border rounded shadow-sm">
          <h2 class="text-lg font-semibold">{{ campaign.title }}</h2>
          <p>{{ campaign.description }}</p>
          <p class="text-sm text-gray-600">Goal: ${{ campaign.goal_amount }}</p>
          <p class="text-sm text-gray-600">By: {{ campaign.creator.name }}</p>
          <Link :href="route('campaigns.show', campaign.id)" class="text-blue-500 mt-2 inline-block">View</Link>
        </div>
      </div>
      <div v-else class="text-gray-500">No campaigns found.</div>
    </div>
</template>
  
<script setup>
  import { Link } from '@inertiajs/vue3'
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })
  
  defineProps({
    campaigns: Array,
  });
</script>
  