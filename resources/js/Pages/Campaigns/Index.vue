<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">All Campaigns</h1>

    <Link
      href="/campaigns/create"
      class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
    >
      Create Campaign
    </Link>

    <!-- Filters -->
    <form @submit.prevent="applyFilters" class="mb-6 flex flex-wrap gap-4 items-end">
      <div>
        <label class="block text-sm font-medium">Title</label>
        <input v-model="filters.title" type="text" class="border rounded px-2 py-1" />
      </div>

      <div>
        <label class="block text-sm font-medium">Category</label>
        <input v-model="filters.category" type="text" class="border rounded px-2 py-1" />
      </div>

      <div>
        <label class="block text-sm font-medium">Created By</label>
        <input v-model="filters.created_by" type="text" class="border rounded px-2 py-1" />
      </div>

      <div>
        <label class="block text-sm font-medium">Status</label>
        <select v-model="filters.status" class="border rounded px-2 py-1">
          <option value="">All</option>
          <option value="active">Active</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
      </div>

      <button 
        type="submit" 
        @click="applyFilters"
        class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800"
      >
        Apply Filters
      </button>
      
      <button 
        type="button" 
        @click="clearFilters"
        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600"
      >
        Clear Filters
      </button>
    </form>

    <!-- Campaign List -->
    <div v-if="campaigns.length">
      <div v-for="campaign in campaigns" :key="campaign.id" class="p-4 mb-4 border rounded shadow-sm">
        <h2 class="text-lg font-semibold">{{ campaign.title }}</h2>
        <p>{{ campaign.description }}</p>
        <p class="text-sm text-gray-600">Goal: ${{ campaign.goal_amount }}</p>
        <p class="text-sm text-gray-600">Category: {{ campaign.category || '—' }}</p>
        <p class="text-sm text-gray-600">Status: {{ campaign.status }}</p>
        <p v-if="campaign.creator" class="text-sm text-gray-600">By: {{ campaign.creator.name }}</p>

        <Link :href="route('campaigns.show', campaign.id)" class="text-blue-500 mr-4">View</Link>

        <Link
          v-if="campaign.creator && campaign.creator.id === authUserId"
          :href="route('campaigns.edit', campaign.id)"
          class="text-green-600 mr-4"
        >
          Edit
        </Link>

        <button
          v-if="campaign.creator && campaign.creator.id === authUserId"
          @click="deleteCampaign(campaign.id)"
          class="text-red-600"
        >
          Delete
        </button>
      </div>

      <!-- Pagination -->
      <Pagination :links="pagination.links" />
    </div>

    <div v-else class="text-gray-500">No campaigns found.</div>
  </div>
</template>

<script setup>
import { ref, computed, watch } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'
import Layout from '@/Layouts/Layout.vue'
import Pagination from '@/Components/Pagination.vue'
import { route } from 'ziggy-js'

defineOptions({ layout: Layout })

const page = usePage()
const campaigns = computed(() => page.props.campaigns?.data || [])
const pagination = computed(() => page.props.campaigns || {})
const authUserId = computed(() => page.props.auth?.user?.id)

// Initial filter values from URL query (preserved on reload)
const filters = ref({
  title: page.props.filters?.title || '',
  category: page.props.filters?.category || '',
  created_by: page.props.filters?.created_by || '',
  status: page.props.filters?.status || '',
})

// Update filters when page props change
watch(() => page.props.filters, (newFilters) => {
  if (newFilters) {
    filters.value = {
      title: newFilters.title || '',
      category: newFilters.category || '',
      created_by: newFilters.created_by || '',
      status: newFilters.status || '',
    }
  }
}, { immediate: true })

// Submit filters via query string
const applyFilters = () => {
  const data = {
    title: filters.value.title || '',
    category: filters.value.category || '',
    created_by: filters.value.created_by || '',
    status: filters.value.status || '',
  };
  
  // Remove empty values to clean up the URL
  Object.keys(data).forEach(key => {
    if (data[key] === '') {
      delete data[key]
    }
  })
  
  router.get(route('campaigns.index'), data, {
    preserveState: true,
    preserveScroll: true,
    replace: true, // Use replace to avoid adding to browser history
  });
}

const clearFilters = () => {
  filters.value = {
    title: '',
    category: '',
    created_by: '',
    status: '',
  }
  router.get(route('campaigns.index'), {}, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  })
}

const deleteCampaign = (id) => {
  if (confirm('Are you sure you want to delete this campaign?')) {
    router.delete(route('campaigns.destroy', id))
  }
}
</script>
