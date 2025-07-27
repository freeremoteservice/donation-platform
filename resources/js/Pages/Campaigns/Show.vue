<template>
    <div class="p-6">
      <h1 class="text-2xl font-bold">{{ campaign.title }}</h1>
      <p class="mb-4">{{ campaign.description }}</p>
  
      <div>
        <strong>Goal:</strong>
        <span class="ml-1">${{ formatCurrency(campaign.goal_amount) }}</span>
      </div>
      <div>
        <strong>Total Donated:</strong>
        <span class="ml-1">${{ campaign.total_donated.toFixed(2) }}</span>
      </div>
      <div>
        <strong>Donations:</strong>
        <span class="ml-1">{{ campaign.donations_count }}</span>
      </div>
      <div>
        <strong>Deadline:</strong>
        <span class="ml-1">{{ formatDate(campaign.deadline) }}</span>
      </div>
      <div>
        <strong>Created by:</strong>
        <span class="ml-1">{{ campaign.creator?.name || 'Unknown' }}</span>
      </div>
  
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

  const formatCurrency = (value) => {
    const num = Number(value);
    return isNaN(num) ? '0.00' : num.toFixed(2);
  };

  const formatDate = (date) => {
    if (!date) return '';
    const d = new Date(date);
    return d.toLocaleDateString(undefined, { year: 'numeric', month: 'long', day: 'numeric' });
  };
</script>
  