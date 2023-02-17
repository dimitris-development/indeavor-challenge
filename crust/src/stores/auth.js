import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

import router from '@/router'

const baseURL = `${import.meta.env.VITE_API_URL}`

export const useAuthStore = defineStore('auth', {
  state: () => {
    return {
      user: JSON.parse(localStorage.getItem('user'))
    }
  },
  actions: {
    async login(email, password) {
      try {
        const user = await fetchWrapper.post(`${baseURL}/login`, { email, password });    
        this.user = user
        localStorage.setItem('user', JSON.stringify(user))
        router.push('/')
      } catch (error) {
        //const alertStore = useAlertStore()
        //alertStore.error(error)       
      }
    },
    logout() {
      try {
        fetchWrapper.post(`${baseURL}/logout`);
        localStorage.removeItem('user')
        this.$reset()
        router.push('/login')
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    }
  }
})
