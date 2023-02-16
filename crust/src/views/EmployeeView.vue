<template>
  <DataTable
    v-model:server-options="serverOptions"
    :server-items-length="employee.total"
    :loading="employee.loading"
    :headers="headers"
    :items="employee.items"
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
      rowsPerPage: 1,
      sortBy: "last_name",
      sortType: "asc",
    },
  }),
  beforeMount() {
    this.employee.get(this.serverOptions);
  },
  watch: {
    serverOptions: {
      handler() {
        this.employee.get(this.serverOptions);
      },
    },
  },
};
</script>
