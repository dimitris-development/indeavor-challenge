import { defineStore } from 'pinia'
import { fetchWrapper } from '@/helpers/fetchWrapper.js'

import router from '@/router'
const employeesURL = `${import.meta.env.VITE_API_URL}/employees`

export const useEmployeeStore = defineStore('employees', {
  state: () => {
    return {
      items: [],
      item: {
        uuid: '',
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
    async updateSkills(employeeUUID, skills, updateType) {
      const method = {
        'attach' : 'post',
        'detach' : 'delete' 
      }

      try {
        const employee = await fetchWrapper[method[updateType]](`${employeesURL}/${employeeUUID}/skills`, {
          skills
        })
        this.item = employee
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)  
      }
    },
    async updateDetails(employeeUUID, details) {
      try {
        const employee = await fetchWrapper.put(`${employeesURL}/${employeeUUID}`, details)
        this.item = employee
      } catch (error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error) 
      }
    },
    async create(details, skills) {
      try {
        const employee = await fetchWrapper.post(`${employeesURL}`, details)
        
        if (skills.length) {
          const employeeUUID = employee.uuid
          await this.updateSkills(employeeUUID, skills, 'attach')
          router.push({path: `/employees/${employeeUUID}`})
        }
      } catch(error) {
        console.log(error)
        //const alertStore = useAlertStore()
        //alertStore.error(error)
      }
    }
  }
})

