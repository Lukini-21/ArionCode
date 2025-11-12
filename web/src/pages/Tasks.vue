<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Tasks</h2>

        <div v-if="loading" class="text-gray-500">Loading...</div>

        <n-data-table
            :columns="columns"
            :data="tasks"
            bordered
            striped
        />
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../api/client'
import { NDataTable } from "naive-ui"

const tasks = ref<any[]>([])
const loading = ref(true)
const columns = [
    { title: 'Title', key: 'title' },
    { title: 'Project', key: 'project' },
    { title: 'Status', key: 'status' },
    { title: 'Assignee', key: 'assignee' },
]

onMounted(async () => {
    const { data } = await api.get('/tasks')
    tasks.value = data.data.map(task => ({
        ...task,
        assignee: task.assigned_to ? task.assigned_to.email : null,
        project: task.project.name,
    }))
    loading.value = false
})
</script>
