import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

import router from '@/router'

const loginURL = `${import.meta.env.VITE_API_URL}/login`

export const useAuthStore = defineStore('auth', {
  state: () => {
    return {
      user: JSON.parse(localStorage.getItem('user'))
    }
  },
  actions: {
    async login(email, password) {
      try {
        const user = await fetchWrapper.post(loginURL, { email, password });    
        this.user = user
        localStorage.setItem('user', JSON.stringify(user))
        router.push('/')
      } catch (error) {
        //const alertStore = useAlertStore()
        //alertStore.error(error)       
      }
    },
    logout() {
      this.user = null
      localStorage.removeItem('user')
    }
  }
})
