<template>
    <nav class="flex justify-center space-x-1 mt-6">
      <button
        v-for="link in links"
        :key="link.url || link.label"
        :disabled="!link.url"
        :class="[
          'px-3 py-1 rounded',
          link.active ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700',
          !link.url ? 'cursor-not-allowed opacity-50' : 'cursor-pointer',
        ]"
        @click.prevent="goToPage(link.url)"
        v-html="link.label"
      ></button>
    </nav>
</template>

<script setup>
import { router } from '@inertiajs/vue3'

const props = defineProps({
links: {
    type: Array,
    required: true,
},
})

const goToPage = (url) => {
    if (!url) return
    router.visit(url, { preserveState: true, preserveScroll: true })
}
</script>
