import Echo from 'laravel-echo'
import Pusher from 'pusher-js'

window.Pusher = Pusher

export const echo = new Echo({
  broadcaster: 'reverb',
  key: import.meta.env.VITE_REVERB_APP_KEY || 'wsk',
  wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
  wsPort: import.meta.env.VITE_REVERB_PORT || 8081,
  wssPort: import.meta.env.VITE_REVERB_PORT || 8081,
  forceTLS: false,
  disableStats: true,
  enabledTransports: ['ws', 'wss'],
})
