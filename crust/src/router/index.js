import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from "@/stores/auth"
import HomeView from '@/views/HomeView.vue'
import LoginView from '@/views/LoginView.vue'
import EmployeeView from '@/views/EmployeeView.vue'
import EmployeeEditView from '@/views/EmployeeEditView.vue'
import EmployeeNewView from '@/views/EmployeeNewView.vue'
import SkillView from '@/views/SkillView.vue'

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
      component: LoginView
    },
    {
      path: '/employees',
      name: 'employees',
      component: EmployeeView
    },
    {
      path: '/employees/:employeeUUID',
      name: 'employee',
      component: EmployeeEditView
    },
    {
      path: '/employees/new',
      name: 'new_employee',
      component: EmployeeNewView
    },
    {
      path: '/skills',
      name: 'skill',
      component: SkillView
    }
  ]
})

router.beforeEach(async (to) => {
  // redirect to login page if not logged in and trying to access a restricted page
  const publicPages = ['/login']
  const authRequired = !publicPages.includes(to.path)

  const auth = useAuthStore()
  const isAuthenticated = !!auth.user?.token

  if (authRequired && !isAuthenticated) return '/login'
  if (isAuthenticated && to.name === 'login') return '/'
});

export default router
