<template>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex space-x-4">
          <router-link to="/admin" class="font-semibold text-gray-700 hover:text-blue-600">Admin Dashboard</router-link>
          <!-- Add other admin links here -->
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
  // No special logic needed here, just a simple layout for admin pages.
</script>
  