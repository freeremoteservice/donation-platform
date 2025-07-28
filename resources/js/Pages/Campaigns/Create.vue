<template>
    <div class="max-w-2xl mx-auto p-6 bg-white rounded shadow">
      <h1 class="text-2xl mb-4 font-semibold">Create Campaign</h1>
  
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
          <div v-if="form.errors.category" class="text-red-500">{{ form.errors.category }}</div>
        </div>
  
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Create
        </button>
      </form>
    </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/vue3'
  
  const form = useForm({
    title: '',
    description: '',
    goal_amount: 0,
    deadline: '',
    category: '',
    status: 'active',
  })
  
  const errors = ref({})
  
  const submit = () => {
    form.post(route('campaigns.store'), {
      onError: (errs) => {
        errors.value = errs
      },
    })
  }
</script>
