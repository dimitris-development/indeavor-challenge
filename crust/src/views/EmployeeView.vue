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
      { text: "LAST NAME", value: "last_name" },
    ],
    serverOptions: {
      page: 1,
      rowsPerPage: 5,
      sortBy: "first_name",
      sortType: "desc",
    },
  }),
  beforeMount() {
    this.employee.get();
  },
};
</script>
