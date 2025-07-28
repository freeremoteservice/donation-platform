<template>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
      <h1 class="text-2xl mb-4 font-semibold">Edit Campaign</h1>
  
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block font-medium">Title</label>
          <input v-model="form.title" type="text" class="w-full border rounded px-3 py-2" />
          <div v-if="errors.title" class="text-red-600 mt-1">{{ errors.title }}</div>
        </div>
  
        <div class="mb-4">
          <label class="block font-medium">Description</label>
          <textarea v-model="form.description" class="w-full border rounded px-3 py-2"></textarea>
          <div v-if="errors.description" class="text-red-600 mt-1">{{ errors.description }}</div>
        </div>
  
        <div class="mb-4">
          <label class="block font-medium">Goal Amount ($)</label>
          <input v-model.number="form.goal_amount" type="number" min="0" step="0.01" class="w-full border rounded px-3 py-2" />
          <div v-if="errors.goal_amount" class="text-red-600 mt-1">{{ errors.goal_amount }}</div>
        </div>
  
        <div class="mb-4">
          <label class="block font-medium">Deadline</label>
          <input v-model="form.deadline" type="date" class="w-full border rounded px-3 py-2" />
          <div v-if="errors.deadline" class="text-red-600 mt-1">{{ errors.deadline }}</div>
        </div>

        <div class="mb-4">
          <label class="block font-medium">Category</label>
          <input v-model="form.category" type="text" class="w-full border rounded px-3 py-2" />
          <div v-if="errors.category" class="text-red-600 mt-1">{{ errors.category }}</div>
        </div>

        <div class="mb-4">
          <label class="block font-medium">Status</label>
          <select v-model="form.status" class="w-full border rounded px-3 py-2">
            <option value="active">Active</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
          <div v-if="errors.status" class="text-red-600 mt-1">{{ errors.status }}</div>
        </div>
  
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Update
        </button>
      </form>
    </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  import { usePage } from '@inertiajs/vue3'
  
  const page = usePage()
  const campaign = page.props.campaign
  
  const form = useForm({
    title: campaign.title,
    description: campaign.description,
    goal_amount: campaign.goal_amount,
    deadline: campaign.deadline || '',
    category: campaign.category,
    status: campaign.status,
  })
  
  const errors = ref({})
  
  const submit = () => {
    form.put(route('campaigns.update', campaign.id), {
      onError: (errs) => {
        errors.value = errs
      },
    })
  }
</script>
