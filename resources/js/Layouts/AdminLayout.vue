<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 px-4 sm:px-6 py-4 shadow-sm">
      <div class="flex justify-between items-center">
        <!-- Brand and desktop nav -->
        <div class="flex items-center space-x-4">
          <div class="hidden sm:flex space-x-4">
            <NavLink href="/admin" exact>Dashboard</NavLink>
            <NavLink href="/admin/users">Users</NavLink>
            <NavLink href="/admin/campaigns">Campaigns</NavLink>
          </div>
        </div>

        <!-- Mobile toggle -->
        <button @click="toggleMobileMenu" class="sm:hidden focus:outline-none">
          <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path :class="{ 'hidden': mobileMenuOpen, 'inline': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            <path :class="{ 'inline': mobileMenuOpen, 'hidden': !mobileMenuOpen }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>

        <!-- User Dropdown -->
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
            >
              Profile
            </Link>
            <button
              @click.prevent="logout"
              class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100"
            >
              Logout
            </button>
          </div>
        </div>
      </div>

      <!-- Mobile Nav -->
      <div v-if="mobileMenuOpen" class="sm:hidden mt-2 space-y-2">
        <NavLink href="/admin" class="block">Dashboard</NavLink>
        <NavLink href="/admin/users" class="block">Users</NavLink>
        <NavLink href="/admin/campaigns" class="block">Campaigns</NavLink>
      </div>
    </nav>

    <!-- Main Content -->
    <main class="p-4 sm:p-6">
      <slot />
    </main>
  </div>
</template>


<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { router, Link, usePage } from '@inertiajs/vue3'
import NavLink from '@/Components/NavLink.vue'

const user = usePage().props.auth.user
const dropdownOpen = ref(false)
const mobileMenuOpen = ref(false)
const dropdownRef = ref(null)

function toggleDropdown() {
  dropdownOpen.value = !dropdownOpen.value
}

function toggleMobileMenu() {
  mobileMenuOpen.value = !mobileMenuOpen.value
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

function logout() {
  dropdownOpen.value = false
  router.post('/logout')
}
</script>
