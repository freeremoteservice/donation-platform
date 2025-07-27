<template>
  <div class="p-6 max-w-md mx-auto">
    <h1 class="text-2xl font-bold mb-4">Donate to "{{ campaign.title }}"</h1>

    <form @submit.prevent="submit" novalidate>
      <div class="mb-4">
        <label for="amount" class="block mb-1 font-semibold">Amount ($)</label>
        <input
          id="amount"
          v-model.number="form.amount"
          type="number"
          min="1"
          step="0.01"
          placeholder="Enter donation amount"
          class="w-full border px-3 py-2 rounded"
          :class="{ 'border-red-500': form.errors.amount }"
          required
          autofocus
        />
        <div v-if="form.errors.amount" class="text-red-500 text-sm mt-1">
          {{ form.errors.amount }}
        </div>
      </div>

      <button
        type="submit"
        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50"
        :disabled="form.processing"
      >
        <span v-if="form.processing">Processing...</span>
        <span v-else>Submit Donation</span>
      </button>
    </form>
  </div>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3'
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })

  const props = defineProps({
    campaign: Object,
  })

  const form = useForm({
    amount: '',
  })

  const submit = () => {
    form.post(route('donations.store', props.campaign.id), {
      onSuccess: () => {
        form.reset('amount') // Clear amount field after successful submission
      },
    })
  }
</script>
