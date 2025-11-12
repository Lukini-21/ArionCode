import api from './client'
import { useAuthStore } from '../store/auth'

export async function login(email: string, password: string) {
  const { data } = await api.post('/auth/login', { email, password })
  const store = useAuthStore()
  store.setToken(data.token)
  return data
}
