import { defineStore } from 'pinia'

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
    markAllRead() {
      this.unreadCount = 0
    },
    clear() {
      this.items = []
      this.unreadCount = 0
    },
  },
})
