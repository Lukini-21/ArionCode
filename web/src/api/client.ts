import axios from 'axios'
import { useAuthStore } from '../store/auth.ts'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE || 'https://127.0.0.1:5173',
})

api.interceptors.request.use(config => {
  const auth = useAuthStore()
  if (auth.token) config.headers.Authorization = `Bearer ${auth.token}`
  return config
})

export default api
