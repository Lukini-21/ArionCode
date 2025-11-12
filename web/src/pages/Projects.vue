<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Projects</h2>

        <div v-if="loading" class="text-gray-500">Loading...</div>
        <n-data-table
            :columns="columns"
            :data="projects"
            bordered
            striped
        />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../api/client'
import { NDataTable } from 'naive-ui'

const projects = ref<any[]>([])
const loading = ref(true)
const columns = [
    { title: 'Name', key: 'name' },
    { title: 'Organization', key: 'organization' },
    { title: 'Status', key: 'status' },
    { title: 'Tasks', key: 'tasks_count' },
    { title: 'Visibility', key: 'is_public' }
]

onMounted(async () => {
    const { data } = await api.get('/projects')
    projects.value = data.data.map(project => ({
        ...project,
        is_public: project.is_public ? "Public" : "Private",
        organization: project.organization.name,
    }))

    loading.value = false
})
</script>
