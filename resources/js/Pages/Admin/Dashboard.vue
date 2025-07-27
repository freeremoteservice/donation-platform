<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <Head title="Dashboard" />

  <AdminLayout>
    <h2 class="text-xl font-semibold leading-tight text-gray-800 mb-6">
      Dashboard
    </h2>

    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
      You're logged in!
    </div>
  </AdminLayout>
</template>
