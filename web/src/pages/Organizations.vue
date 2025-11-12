<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Organizations</h2>

        <div v-if="loading" class="text-gray-500">Loading...</div>
        <n-data-table
            :columns="columns"
            :data="orgs"
            bordered
            striped
        />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../api/client'
import { NDataTable } from "naive-ui"

const orgs = ref<any[]>([])
const loading = ref(true)
const columns = [
    { title: 'Name', key: 'name' },
    { title: 'Users count', key: 'u_count' },
]

onMounted(async () => {
    const { data } = await api.get('/organizations')
    orgs.value = data.data.map(org => ({
        ...org,
        u_count: org.users.length,
    }))
    loading.value = false
})
</script>
