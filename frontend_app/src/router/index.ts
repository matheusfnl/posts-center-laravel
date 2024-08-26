import { createRouter, createWebHistory } from 'vue-router'
import PostsContainer from '@/components/home/PostsContainer.vue';
import SignUp from '@/views/SignUp.vue'
import PostShow from '@/views/PostShow.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: PostsContainer
    },

    {
      path: '/register',
      name: 'register',
      component: SignUp,
    },

    {
      path: '/post/:id',
      name: 'posts-show',
      component: PostShow,
    }
  ]
})

export default router
