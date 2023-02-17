import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

const skillsURL = `${import.meta.env.VITE_API_URL}/skills`

export const useSkillStore = defineStore('skills', {
  state: () => {
    return {
      items: [],
      item: {},
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
        // TODO : Refactor
        const queryString = serverOptions.dontPaginate ? 'dontPaginate' : `page=${serverOptions.page}`
        const response = await fetchWrapper.get(`${skillsURL}?${queryString}`)
        
        this.items = response?.data ?? response
        this.page = response?.meta?.current_page
        this.total = response?.meta?.total
        this.rowsPerPage = response?.meta?.per_page
      } catch (error) {
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
    },
    async getOne(skillUUID) {
      try {
        const skill = await fetchWrapper.get(`${skillsURL}/${skillUUID}`)
        this.item = skill
      } catch (error) {
        console.log(error)
        router.push({ name: 'skills'})
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    },
    async updateDetails(skillUUID, details) {
      try {
        const skill = await fetchWrapper.put(`${skillsURL}/${skillUUID}`, details)
        this.item = skill
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error) 
      }
    },
  }
})

