import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '@/views/HomeView.vue'
import SignUp from '@/views/SignUp.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },

    {
      path: '/register',
      name: 'register',
      component: SignUp,
    }
  ]
})

export default router
