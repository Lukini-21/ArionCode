<template>
    <div class="flex min-h-screen items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">
            <h1 class="text-2xl font-semibold text-center mb-6">Sign in</h1>

            <form @submit.prevent="onSubmit" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input v-model="email" type="email" required
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input v-model="password" type="password" required
                           class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent"/>
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                    {{ loading ? 'Logging in...' : 'Login' }}
                </button>
            </form>
        </div>
    </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { login } from '../api/auth'

const email = ref('')
const password = ref('')
const loading = ref(false)
const router = useRouter()

const onSubmit = async () => {
    loading.value = true
    try {
        await login(email.value, password.value)
        router.push('/projects')
    } catch (err) {
        alert('Invalid credentials')
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>
@media (max-width: 640px) {
    div.w-full.max-w-md {
        padding: 1.5rem;
    }
}
</style>
