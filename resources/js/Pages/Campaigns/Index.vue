<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold mb-4">All Campaigns</h1>
  
      <Link href="/campaigns/create" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create Campaign</Link>
  
      <div v-if="campaigns.length">
        <div v-for="campaign in campaigns" :key="campaign.id" class="p-4 mb-4 border rounded shadow-sm">
          <h2 class="text-lg font-semibold">{{ campaign.title }}</h2>
          <p>{{ campaign.description }}</p>
          <p class="text-sm text-gray-600">Goal: ${{ campaign.goal_amount }}</p>
          <p class="text-sm text-gray-600">By: {{ campaign.creator.name }}</p>
  
          <Link :href="route('campaigns.show', campaign.id)" class="text-blue-500 mr-4">View</Link>
          
          <Link
            v-if="campaign.creator.id === authUserId"
            :href="route('campaigns.edit', campaign.id)"
            class="text-green-600 mr-4"
          >
            Edit
          </Link>
  
          <button
            v-if="campaign.creator.id === authUserId"
            @click="deleteCampaign(campaign.id)"
            class="text-red-600"
          >
            Delete
          </button>
        </div>
      </div>
  
      <div v-else class="text-gray-500">No campaigns found.</div>
    </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'
  import { Inertia } from '@inertiajs/inertia'
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })

  const page = usePage()
  const campaigns = page.props.campaigns
  const authUserId = page.props.auth.user?.id

  const deleteCampaign = (id) => {
    if (confirm('Are you sure you want to delete this campaign?')) {
      Inertia.delete(route('campaigns.destroy', id))
    }
  }
</script>
