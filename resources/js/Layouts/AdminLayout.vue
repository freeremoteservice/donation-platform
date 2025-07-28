<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
      <div class="flex space-x-4">
        <Link href="/admin" class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer">Admin Dashboard</Link>
        <Link href="/admin/users" class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer">Users</Link>
        <Link href="/admin/campaigns" class="font-semibold text-gray-700 hover:text-blue-600 cursor-pointer">Campaigns</Link>
      </div>

      <div class="relative" ref="dropdownRef">
        <button @click="toggleDropdown" class="flex items-center text-gray-700 hover:text-blue-600 focus:outline-none">
          <span class="mr-2 font-medium">{{ user.name ?? 'Admin' }}</span>
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </button>

        <div v-if="dropdownOpen" class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
          <Link
            href="/profile"
            class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
            @click.prevent="dropdownOpen = false"
          />
          <form method="POST" action="/logout" @submit.prevent="$inertia.post('/logout')">
            <button
              type="submit"
              class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
              @click="dropdownOpen = false"
            >
              Logout
            </button>
          </form>
        </div>
      </div>
    </nav>

    <main class="p-6">
      <slot />
    </main>
  </div>
</template>

<script setup>
  import { ref, onMounted, onBeforeUnmount } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'

  const user = usePage().props.auth.user
  const dropdownOpen = ref(false)
  const dropdownRef = ref(null)

  function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value
  }

  // Close dropdown when clicking outside
  function onClickOutside(event) {
    if (dropdownRef.value && !dropdownRef.value.contains(event.target)) {
      dropdownOpen.value = false
    }
  }

  onMounted(() => {
    document.addEventListener('click', onClickOutside)
  })

  onBeforeUnmount(() => {
    document.removeEventListener('click', onClickOutside)
  })
</script>
