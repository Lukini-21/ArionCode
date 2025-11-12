<template>
    <div>
        <h2 class="text-2xl font-semibold mb-4">Notifications</h2>

        <div v-if="!store.items.length" class="text-gray-500">
            No notifications yet
        </div>

        <ul class="space-y-2">
            <li
                v-for="n in store.items"
                :key="n.id"
                class="p-4 bg-white rounded-lg shadow"
            >
                <p>{{ n.message }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ n.created_at || '' }}</p>
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
import { useNotificationStore } from '../store/notifications'
const store = useNotificationStore()
</script>
