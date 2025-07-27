<template>
    <div class="p-6 max-w-md mx-auto">
      <h1 class="text-2xl font-bold mb-4">Donate to "{{ campaign.title }}"</h1>
  
      <form @submit.prevent="submit">
        <div class="mb-4">
          <label class="block mb-1 font-semibold">Amount ($)</label>
          <input
            v-model="form.amount"
            type="number"
            min="1"
            class="w-full border px-3 py-2 rounded"
            required
          />
          <div v-if="form.errors.amount" class="text-red-500 text-sm">{{ form.errors.amount }}</div>
        </div>
  
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Submit Donation
        </button>
      </form>
    </div>
</template>

<script setup>
  import { useForm } from '@inertiajs/vue3';
  import Layout from '@/Layouts/Layout.vue'

  defineOptions({ layout: Layout })
  
  const props = defineProps({
    campaign: Object,
  });
  
  const form = useForm({
    amount: '',
  });
  
  const submit = () => {
    form.post(route('donations.store', props.campaign.id));
  };
</script>
  