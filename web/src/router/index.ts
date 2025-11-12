import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../store/auth'
import Login from '../pages/Login.vue'
import Projects from '../pages/Projects.vue'
import Tasks from '../pages/Tasks.vue'
import Notifications from '../pages/Notifications.vue'
import Organizations from '../pages/Organizations.vue'

const routes = [
  { path: '/login', component: Login },
  {
    path: '/',
    children: [
      { path: 'projects', component: Projects },
      { path: 'tasks', component: Tasks },
      { path: 'notifications', component: Notifications },
      { path: 'organizations', component: Organizations },
      { path: '', redirect: '/projects' },
    ],
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, _from, next) => {
  const auth = useAuthStore()
  if (!auth.token && to.path !== '/login') next('/login')
  else next()
})

export default router
