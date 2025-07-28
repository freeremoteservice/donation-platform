<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">My Donations</h1>

    <div v-if="donations.length" class="space-y-4">
      <div v-for="donation in donations" :key="donation.id" class="border rounded p-4 shadow-sm">
        <p class="text-lg font-semibold">
          ${{ Number(donation.amount).toFixed(2) }} to
          <span
            class="text-blue-600 hover:underline cursor-pointer"
            @click="goToCampaign(donation.campaign.id)"
          >
            {{ donation.campaign.title }}
          </span>
        </p>
        <p class="text-sm text-gray-500">{{ formatDate(donation.created_at) }}</p>
      </div>
    </div>

    <div v-else class="text-gray-500 italic">You haven’t donated to any campaigns yet.</div>
  </div>
</template>

<script setup>
  import Layout from '@/Layouts/Layout.vue'
  import { router } from '@inertiajs/vue3'

  defineOptions({ layout: Layout })

  const props = defineProps({
    donations: Array,
  })

  function formatDate(dateString) {
    const date = new Date(dateString)
    return date.toLocaleDateString(undefined, {
      year: 'numeric',
      month: 'short',
      day: 'numeric',
    })
  }

  function goToCampaign(campaignId) {
    router.visit(route('campaigns.show', campaignId))  // <-- use router.visit() for navigation
  }
</script>
