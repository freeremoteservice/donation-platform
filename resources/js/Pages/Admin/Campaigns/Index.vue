<template>
    <div class="p-6 max-w-6xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Manage Campaigns</h1>
      <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
          <tr>
            <th class="border p-2">Title</th>
            <th class="border p-2">Creator</th>
            <th class="border p-2">Status</th>
            <th class="border p-2">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="campaign in campaigns" :key="campaign.id">
            <td class="border p-2">{{ campaign.title }}</td>
            <td class="border p-2">{{ campaign.creator.name }}</td>
            <td class="border p-2">
              <select :value="campaign.status" @change="changeStatus(campaign.id, $event.target.value)" class="border rounded px-2 py-1 text-sm w-full bg-white">
                <option value="active">Active</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
            </td>
            <td class="border p-2">
              <button @click="deleteCampaign(campaign.id)" class="text-red-600 hover:underline">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>
  
<script setup>
  import { router } from '@inertiajs/vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue'

  defineOptions({
    layout: AdminLayout
  })
  
  const props = defineProps({
    campaigns: Array,
  });
  
  function changeStatus(campaignId, status) {
    router.put(route('admin.campaigns.update', campaignId), { status });
  }
  
  function deleteCampaign(campaignId) {
    if (confirm('Are you sure you want to delete this campaign?')) {
      router.delete(route('admin.campaigns.destroy', campaignId));
    }
  }
</script>
  