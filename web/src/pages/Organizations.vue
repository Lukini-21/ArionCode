<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Organizations</h2>

        <div v-if="loading" class="text-gray-500">Loading...</div>

        <table v-else class="w-full bg-white rounded-lg shadow text-sm">
            <thead class="bg-gray-50 text-left">
            <tr>
                <th class="p-3">ID</th>
                <th class="p-3">Name</th>
                <th class="p-3">Created</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="org in orgs" :key="org.id" class="border-t hover:bg-gray-50">
                <td class="p-3">{{ org.id }}</td>
                <td class="p-3 font-medium">{{ org.name }}</td>
                <td class="p-3 text-gray-500">{{ org.created_at || '—' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../api/client'

const orgs = ref<any[]>([])
const loading = ref(true)

onMounted(async () => {
    const { data } = await api.get('/organizations')
    orgs.value = data
    loading.value = false
})
</script>
