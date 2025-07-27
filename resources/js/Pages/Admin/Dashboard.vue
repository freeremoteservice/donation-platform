<script setup>
  import AdminLayout from '@/Layouts/AdminLayout.vue';
  import { Head } from '@inertiajs/vue3';

  const props = defineProps({
    totalUsers: Number,
    totalCampaigns: Number,
    totalDonations: [Number, String],
  });

  const formattedTotalDonations = Number(props.totalDonations || 0).toFixed(2);
</script>

<template>
  <Head title="Admin Dashboard" />

  <AdminLayout>
    <h1 class="text-2xl font-bold mb-4">Admin Dashboard</h1>

    <div class="bg-white shadow rounded p-6">
      <p><strong>Total Users:</strong> {{ totalUsers }}</p>
      <p><strong>Total Campaigns:</strong> {{ totalCampaigns }}</p>
      <p><strong>Total Donations:</strong> ${{ formattedTotalDonations }}</p>
    </div>
  </AdminLayout>
</template>
