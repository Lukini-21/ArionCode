<template>
    <div class="relative">
        <button @click="open = !open" class="relative">
            🔔
            <span v-if="store.unreadCount"
                  class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5">
        {{ store.unreadCount }}
      </span>
        </button>

        <div v-if="open" class="absolute right-0 mt-2 w-64 bg-white shadow-lg rounded-xl overflow-hidden z-50">
            <div v-if="!store.items.length" class="p-4 text-gray-500 text-sm">No notifications</div>
            <ul v-else>
                <li v-for="n in store.items" :key="n.id"
                    class="px-4 py-2 border-b hover:bg-gray-50 text-sm">
                    {{ n.message }}
                </li>
            </ul>
            <button @click="store.markAllRead()" class="w-full py-2 text-blue-600 text-sm hover:bg-gray-100">
                Mark all as read
            </button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { useNotificationStore } from '../store/notifications'

const open = ref(false)
const store = useNotificationStore()
</script>
