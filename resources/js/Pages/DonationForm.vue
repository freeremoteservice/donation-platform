<script setup>
defineProps(['id', 'campaign']);
</script>

<template>
  <div class="p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Donate to {{ campaign.title }}</h1>

    <form @submit.prevent="submitDonation">
      <label class="block mb-2">
        <span class="text-gray-700">Amount</span>
        <input v-model="amount" type="number" min="1" class="mt-1 block w-full border px-3 py-2 rounded" />
      </label>

      <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded">
        Confirm Donation
      </button>
    </form>
  </div>
</template>

<script>
import { ref } from 'vue'

export default {
  setup() {
    const amount = ref(0)

    function submitDonation() {
      alert(`You donated $${amount.value}! (Backend handling coming soon)`)
    }

    return { amount, submitDonation }
  },
}
</script>
