<template>
    <div class="flex h-screen bg-gray-100 text-gray-800">
        <!-- Sidebar -->
        <aside
            :class="[
        'bg-gray-800 text-white w-64 flex-shrink-0 flex flex-col transition-transform duration-200',
        { '-translate-x-full sm:translate-x-0': !openSidebar }
      ]"
        >
            <div class="px-6 py-4 font-bold text-lg border-b border-gray-700">
                ArionCoder
            </div>
            <nav class="flex-1 px-4 py-2 space-y-2">
                <RouterLink v-for="link in links" :key="link.to"
                            :to="link.to"
                            class="block px-3 py-2 rounded-lg hover:bg-gray-700 transition"
                            active-class="bg-gray-700"
                >
                    {{ link.label }}
                </RouterLink>
            </nav>
            <button
                @click="logout"
                class="m-4 bg-red-600 hover:bg-red-700 rounded-lg py-2 text-sm font-semibold"
            >
                Logout
            </button>
        </aside>

        <!-- Main content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <Header @toggleSidebar="openSidebar = !openSidebar" />
            <main class="flex-1 overflow-y-auto p-6">
                <RouterView />
            </main>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import Header from '../components/Header.vue'
import { useAuthStore } from '../store/auth'
import { useRouter, RouterLink, RouterView } from 'vue-router'

const router = useRouter()
const auth = useAuthStore()
const openSidebar = ref(false)

const links = [
    { label: 'Projects', to: '/projects' },
    { label: 'Tasks', to: '/tasks' },
    { label: 'Organizations', to: '/organizations' },
    { label: 'Notifications', to: '/notifications' },
]

function logout() {
    auth.clearToken()
    router.push('/login')
}
</script>

<style scoped>
@media (max-width: 640px) {
    aside {
        position: absolute;
        height: 100%;
        z-index: 50;
    }
}
</style>
