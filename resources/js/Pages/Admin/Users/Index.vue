<template>
    <div class="p-6 max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Manage Users</h1>
      <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
          <tr>
            <th class="border p-2">Name</th>
            <th class="border p-2">Email</th>
            <th class="border p-2">Role</th>
            <th class="border p-2">Change Role</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="user in users" :key="user.id">
            <td class="border p-2">{{ user.name }}</td>
            <td class="border p-2">{{ user.email }}</td>
            <td class="border p-2">{{ user.role }}</td>
            <td class="border p-2">
              <select :value="user.role" @change="changeRole(user.id, $event.target.value)" class="border rounded px-2 py-1">
                <option value="user">User</option>
                <option value="admin">Admin</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
</template>
  
<script setup>
  import { router } from '@inertiajs/vue3';
  import AdminLayout from '@/Layouts/AdminLayout.vue'

  defineOptions({
    layout: AdminLayout
  })
  
  const props = defineProps({
    users: Array,
  });
  
  function changeRole(userId, role) {
    router.put(route('admin.users.update', userId), { role });
  }
</script>
  