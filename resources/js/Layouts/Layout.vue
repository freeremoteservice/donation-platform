<template>
  <div class="min-h-screen bg-gray-100">
    <nav class="bg-white border-b border-gray-200 shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
          <!-- Left: Logo & Links -->
          <div class="flex">
            <!-- Desktop nav -->
            <div class="hidden sm:-my-px sm:ml-6 sm:flex sm:space-x-8 items-center">
              <NavLink :href="route('campaigns.index', {}, false)">Campaigns</NavLink>
              <NavLink :href="route('donations.mine', {}, false)">My Donations</NavLink>
              <NavLink v-if="isAdmin" :href="route('admin.dashboard', {}, false)" exact>Admin</NavLink>
            </div>
          </div>

          <!-- Right: Dropdown -->
          <div class="flex items-center">
            <!-- Mobile hamburger -->
            <button
              @click="mobileOpen = !mobileOpen"
              class="sm:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-800 focus:outline-none"
            >
              <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                <path
                  v-if="!mobileOpen"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"
                />
                <path
                  v-else
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>

            <!-- Dropdown -->
            <div class="relative ml-3" @click="toggleDropdown">
              <div class="flex items-center cursor-pointer">
                <span class="text-gray-700 font-medium">{{ userName }}</span>
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
              </div>

              <div
                v-show="dropdownOpen"
                class="absolute right-0 mt-2 w-32 bg-white text-black rounded shadow-lg z-50"
              >
                <Link
                  href="/logout"
                  method="post"
                  as="button"
                  class="block w-full px-4 py-2 text-left text-sm hover:bg-gray-100"
                >
                  Logout
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="mobileOpen" class="sm:hidden px-4 pt-2 pb-4 space-y-1">
        <NavLink :href="route('campaigns.index', {}, false)" class="block">Campaigns</NavLink>
        <NavLink :href="route('donations.mine', {}, false)" class="block">My Donations</NavLink>
        <NavLink v-if="isAdmin" :href="route('admin.dashboard', {}, false)" class="block">Admin</NavLink>
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
import NavLink from '@/Components/NavLink.vue'

const page = usePage()
const isAdmin = page.props.auth?.user?.role === 'admin'
const userName = page.props.auth?.user?.name || 'User'

const dropdownOpen = ref(false)
const mobileOpen = ref(false)

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}
</script>
