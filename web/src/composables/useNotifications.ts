import { onMounted, onBeforeUnmount } from 'vue'
import { useNotificationStore } from '../store/notifications'
import { useAuthStore } from '../store/auth'
import { echo } from '../plugins/echo'

export function useNotifications() {
  const store = useNotificationStore()
  const auth = useAuthStore()

  let channel: ReturnType<typeof echo.channel> | null = null

  onMounted(() => {
    if (!auth.token) {
      console.warn('⛔ Нет токена авторизации — уведомления не подключены')
      return
    }

    channel = echo.channel('notifications')

    channel.listen('.new-notification', (event: any) => {
      console.log('🔔 Получено уведомление:', event)
      store.addNotification(event)
    })

  })

  onBeforeUnmount(() => {
    if (channel) {
      echo.leave(channel.name)
      console.log('🔌 Отключено от канала:', channel.name)
    }
  })
}
