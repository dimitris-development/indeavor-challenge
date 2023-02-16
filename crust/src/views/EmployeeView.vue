<template>
  <DataTable
    v-model:server-options="serverOptions"
    :server-items-length="employee.total"
    :loading="employee.loading"
    :headers="headers"
    :items="employee.items"
    hide-rows-per-page
    must-sort
  />
</template>
<script>
import { useEmployeeStore } from "@/stores/employees";

export default {
  setup: () => {
    const employee = useEmployeeStore();
    return { employee };
  },
  data: () => ({
    headers: [
      { text: "FIRST NAME", value: "first_name" },
      { text: "LAST NAME", value: "last_name", sortable: true },
    ],
    serverOptions: {
      page: 1,
      // This library doesn't allow you to use rowsPerPage as a prop when you have serverOptions
      // For now this is hardcoded
      rowsPerPage: 2,
      sortBy: "last_name",
      sortType: "asc",
    },
  }),
  async beforeMount() {
    await this.employee.get(this.serverOptions);
  },
  watch: {
    serverOptions: {
      handler(oldOptions, newOptions) {
        this.employee.get(this.serverOptions);
      },
    },
  },
};
</script>
