<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">My Donations</h1>
  
      <div v-if="donations.length">
        <div v-for="donation in donations" :key="donation.id" class="border-b py-2">
          <p class="text-sm">
            <strong>${{ donation.amount }}</strong> to 
            <span class="text-blue-500">{{ donation.campaign.title }}</span>
          </p>
          <p class="text-xs text-gray-500">{{ donation.created_at }}</p>
        </div>
      </div>
      <div v-else class="text-gray-500">You haven’t donated to any campaigns yet.</div>
    </div>
</template>

<script setup>
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })
  
  defineProps({
    donations: Array,
  });
</script>
