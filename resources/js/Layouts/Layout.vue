<template>
    <div class="min-h-screen bg-gray-100">
      <nav class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center shadow-sm">
        <div class="flex space-x-4">
          <Link href="/campaigns" class="font-semibold text-gray-700 hover:text-blue-600">Campaigns</Link>
          <Link href="/my-donations" class="font-semibold text-gray-700 hover:text-blue-600">My Donations</Link>
          <Link v-if="isAdmin" href="/admin" class="font-semibold text-gray-700 hover:text-blue-600">Admin</Link>
        </div>
        <div class="relative" @click="toggleDropdown" style="cursor: pointer;">
          <span class="font-semibold text-gray-700 select-none">
            {{ userName }}
            <svg
              class="inline-block w-4 h-4 ml-1"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M19 9l-7 7-7-7"
              />
            </svg>
          </span>

          <div
            v-show="dropdownOpen"
            class="absolute right-0 mt-2 w-32 bg-white text-black rounded shadow-lg z-10"
          >
            <Link
              href="/logout"
              method="post"
              as="button"
              class="block px-4 py-2 hover:bg-gray-200 w-full text-left"
            >
              Logout
            </Link>
          </div>
        </div>
      </nav>
  
      <main class="p-6">
        <slot />
      </main>
    </div>
</template>

<script setup>
  import { ref } from 'vue'
  import { Link, usePage } from '@inertiajs/vue3'

  const page = usePage()

  const isAdmin = page.props.auth?.user?.role === 'admin'
  const userName = page.props.auth?.user?.name || 'User'

  const dropdownOpen = ref(false)
  function toggleDropdown() {
    dropdownOpen.value = !dropdownOpen.value
  }
</script>
