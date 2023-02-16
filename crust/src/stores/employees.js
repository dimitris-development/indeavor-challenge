import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

const employeesURL = `${import.meta.env.VITE_API_URL}/employees`

export const useEmployeeStore = defineStore('employee', {
  state: () => {
    return {
      items: [],
      page: 1,
      total: 4,
      count: 4,
      loading: true
    }
  },
  actions: {
    async get() {
      this.loading = true
      try {
        const items = await fetchWrapper.get(employeesURL)
        this.items = items
      } catch (error) {
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
      this.loading = false
    }
  }
})

