import { defineStore } from 'pinia'
import api from '../api/client'

export const useNotificationStore = defineStore('notifications', {
  state: () => ({
    items: [] as any[],
    unreadCount: 0,
  }),
  actions: {
    addNotification(n: any) {
      this.items.unshift(n)
      this.unreadCount++
    },
    async markAllRead() {
      this.unreadCount = 0
      try {
        await api.post('/notifications/set-all-as-read')
        await this.loadNotifications()
      } catch (error) {
        console.log(error)
      }
    },
    clear() {
      this.items = []
      this.unreadCount = 0
    },
    async loadNotifications(n: any)  {
      try {
        const { data } = await api.get('/notifications')
        this.items = data.data
      } catch (error) {
        console.log(error)
      }
    }
  },
})
