<template>
  <div>
    <h1 class="text-2xl font-bold mb-4">Donate to Campaign</h1>
    <p>You're donating to: {{ campaign.name }}</p>
    <!-- Placeholder form -->
    <form @submit.prevent="submitDonation">
      <input v-model="amount" type="number" placeholder="Amount" class="border p-2 mb-2 block" />
      <button class="bg-blue-500 text-white px-4 py-2">Donate</button>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue'
defineProps(['campaign'])
const amount = ref(0)

function submitDonation() {
  alert(`Donation of $${amount.value} to ${campaign.name} submitted.`)
}
</script>
