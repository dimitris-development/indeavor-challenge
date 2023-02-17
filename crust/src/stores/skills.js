import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

const skillsURL = `${import.meta.env.VITE_API_URL}/skills`

export const useSkillStore = defineStore('skills', {
  state: () => {
    return {
      items: [],
      page: 0,
      total: 0,
      rowsPerPage: 0,
      loading: true
    }
  },
  actions: {
    async get(serverOptions) {
      this.loading = true
      try {
        const response = await fetchWrapper.get(`${skillsURL}?page=${serverOptions.page}`)
        this.items = response.data
        this.page = response.meta.current_page
        this.total = response.meta.total
        this.rowsPerPage = response.meta.per_page
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }

      this.loading = false
    },
    async delete(skillUUID) {
      try {
        await fetchWrapper.delete(`${skillsURL}/${skillUUID}`)
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    }
  }
})

