<template>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex space-x-4">
          <Link
            href="/admin"
            class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer"
          >
            Admin Dashboard
          </Link>
          <Link
            href="/admin/users"
            class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer"
          >
            Users
          </Link>
          <Link
            href="/admin/campaigns"
            class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer"
          >
            Campaigns
          </Link>
        </div>
        <div>
          <form method="POST" action="/logout" @submit.prevent="$inertia.post('/logout')">
            <button type="submit" class="text-red-500 hover:underline">Logout</button>
          </form>
        </div>
      </nav>
  
      <main class="p-6">
        <slot />
      </main>
    </div>
</template>
  
<script setup>
  import { Link } from '@inertiajs/vue3'
</script>
  