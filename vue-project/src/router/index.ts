import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../views/RegisterView.vue')
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('../views/DashboardView.vue'),
      children: [
        {
          path: '',
          name: 'dashboard-home',
          component: () => import('../views/DashboardHomeView.vue')
        },
        {
          path: '/create-ads',
          name: 'create-ads',
          component: () => import('../views/CreateAdsView.vue')
        }
      ]
    },
    {
      path: '/ads',
      name: 'ads',
      component: () => import('../views/AdsView.vue')
    },
  ]
})

export default router
