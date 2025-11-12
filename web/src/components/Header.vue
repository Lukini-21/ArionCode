<template>
    <header class="flex justify-between items-center bg-white shadow-md px-6 py-3">
        <div class="flex items-center gap-3">
            <button @click="$emit('toggleSidebar')" class="sm:hidden text-gray-700">
                ☰
            </button>
            <h1 class="text-lg font-semibold">Dashboard</h1>
        </div>
        <NotificationBell />
    </header>
</template>

<script setup lang="ts">
import NotificationBell from '../components/NotificationBell.vue'
import { useNotifications } from '../composables/useNotifications'
useNotifications()
</script>
