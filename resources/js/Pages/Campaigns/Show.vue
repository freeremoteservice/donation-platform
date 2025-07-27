<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold">{{ campaign.title }}</h1>
      <p class="mb-4">{{ campaign.description }}</p>
  
      <p><strong>Goal:</strong> ${{ campaign.goal_amount }}</p>
      <p><strong>Deadline:</strong> {{ campaign.deadline }}</p>
      <p><strong>Created by:</strong> {{ campaign.creator.name }}</p>
  
      <div class="mt-6">
        <Link :href="route('donations.create', campaign.id)" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
          Donate
        </Link>
      </div>
  
      <div class="mt-8">
        <h2 class="text-xl font-semibold mb-2">Donations</h2>
        <div v-if="campaign.donations.length">
          <div v-for="donation in campaign.donations" :key="donation.id" class="text-sm text-gray-700">
            ${{ donation.amount }} by {{ donation.user.name }}
          </div>
        </div>
        <div v-else class="text-gray-500">No donations yet.</div>
      </div>
    </div>
</template>
  
<script setup>
  import { Link } from '@inertiajs/vue3';
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })
  
  defineProps({
    campaign: Object,
  });
</script>
  