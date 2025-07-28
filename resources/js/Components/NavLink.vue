<script setup>
import { computed } from 'vue'
import { Link, usePage } from '@inertiajs/vue3'

const props = defineProps({
  href: {
    type: String,
    required: true,
  },
  exact: {
    type: Boolean,
    default: false,
  },
})

const page = usePage()

function normalizeUrl(url) {
  if (!url) return ''
  try {
    const u = new URL(url, window.location.origin)
    let pathname = u.pathname
    if (pathname.endsWith('/') && pathname.length > 1) {
      pathname = pathname.slice(0, -1)
    }
    return pathname
  } catch {
    let path = url.split(/[?#]/)[0]
    if (path.endsWith('/') && path.length > 1) {
      path = path.slice(0, -1)
    }
    return path
  }
}

const isActive = computed(() => {
  const currentUrl = normalizeUrl(page.url)
  const targetUrl = normalizeUrl(props.href)
  if (props.exact) {
    return currentUrl === targetUrl
  } else {
    return currentUrl === targetUrl || currentUrl.startsWith(targetUrl + '/')
  }
})

const classes = computed(() =>
  isActive.value
    ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-500 text-sm font-medium leading-5 text-indigo-700 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out'
)
</script>

<template>
  <Link :href="href" :class="classes">
    <slot />
  </Link>
</template>
