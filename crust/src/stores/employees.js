import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

import router from '@/router'
const employeesURL = `${import.meta.env.VITE_API_URL}/employees`

export const useEmployeeStore = defineStore('employees', {
  state: () => {
    return {
      items: [],
      item: {
        first_name: '',
        last_name: '',
        skills: []
      },
      page: 0,
      total: 0,
      rowsPerPage: 0,
      sortType: 'asc',
      loading: true,
    }
  },
  actions: {
    async get(serverOptions) {
      this.loading = true
      try {
        const response = await fetchWrapper.get(`${employeesURL}?sortType=${serverOptions.sortType}&page=${serverOptions.page}`)
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
    async getOne(employeeUUID) {
      try {
        const employee = await fetchWrapper.get(`${employeesURL}/${employeeUUID}`)
        this.item = employee
      } catch (error) {
        console.log(error)
        router.push({ name: 'employees'})
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    },
    async delete(employeeUUID) {
      try {
        await fetchWrapper.delete(`${employeesURL}/${employeeUUID}`)
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    },
  }
})

