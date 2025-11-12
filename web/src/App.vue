<template>
    <div class="min-h-screen w-full bg-gray-100 text-gray-800">
        <nav class="bg-white shadow-md px-6 py-3 flex justify-between items-center">
            <div class="flex items-center gap-5">
                <RouterLink
                    v-for="link in links"
                    :key="link.to"
                    :to="link.to"
                    class="px-3 py-2 rounded-lg hover:bg-gray-200 transition text-sm font-medium"
                    active-class="bg-gray-200 font-semibold"
                    @click="closeOnMobile"
                >
                    {{ link.label }}
                </RouterLink>
            </div>

            <div class="flex items-center flex-row space-x-4">
                <NotificationBell />
                <button
                    @click="logout"
                    class="bg-red-600 hover:bg-red-700 text-white rounded-lg px-4 py-2 text-sm font-semibold transition"
                >
                    Logout
                </button>
            </div>
        </nav>

        <div class="flex-1 flex">
            <div class="flex flex-col w-full">
                <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                    <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                        <RouterView />
                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

import NotificationBell from './components/NotificationBell.vue'
import { useAuthStore } from './store/auth'
import { useRouter, RouterLink, RouterView } from 'vue-router'
import { useNotifications } from './composables/useNotifications'

useNotifications()

const router = useRouter()
const auth = useAuthStore()

const links = [
    { label: 'Organizations', to: '/organizations' },
    { label: 'Projects', to: '/projects' },
    { label: 'Tasks', to: '/tasks' },
]

function closeOnMobile() {
    if (window.matchMedia('(max-width: 639px)').matches) {

    }
}

function logout() {
    auth.clearToken()
    router.push('/login')
}
</script>

<style scoped>

.router-link-active {
    background-color: #e5e7eb;
    font-weight: 600;
}
</style>