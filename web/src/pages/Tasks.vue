<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Tasks</h2>

        <div v-if="loading" class="text-gray-500">Loading...</div>

        <ul v-else class="space-y-2">
            <li
                v-for="task in tasks"
                :key="task.id"
                class="p-4 bg-white rounded-lg shadow flex justify-between items-center"
            >
                <div>
                    <h3 class="font-medium">{{ task.title }}</h3>
                    <p class="text-sm text-gray-500">{{ task.status }}</p>
                </div>
                <span class="text-xs px-2 py-1 rounded-full"
                      :class="{
                'bg-yellow-100 text-yellow-800': task.status === 'todo',
                'bg-green-100 text-green-800': task.status === 'done',
              }">
          {{ task.priority || 'low' }}
        </span>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import api from '../api/client'

const tasks = ref<any[]>([])
const loading = ref(true)

onMounted(async () => {
    const { data } = await api.get('/tasks')
    tasks.value = data
    loading.value = false
})
</script>
