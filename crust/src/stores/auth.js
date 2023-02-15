import { defineStore } from 'pinia'

import { fetchWrapper } from '@/helpers'
import { router } from '@/router'
import { useAlertStore } from '@/stores'

export const useAuthStore = defineStore('auth', {
  state: () => {
    return {
      user: JSON.parse(localStorage.getItem('user'))
    }
  },
  actions: {
    async login(username, password) {
      try {
        // const user = await fetchWrapper.post(`${baseUrl}/`, { username, password });    
        this.user = user
        localStorage.setItem('user', JSON.stringify(user))
        router.push('/')
      } catch (error) {
        const alertStore = useAlertStore()
        alertStore.error(error)       
      }
    },
    logout() {
      this.user = null
      localStorage.removeItem('user')
      router.push('/account/login')
    }
  }
})
