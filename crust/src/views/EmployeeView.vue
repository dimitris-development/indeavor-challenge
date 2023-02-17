<template>
  <v-dialog
    v-model="deleteDialog"
    persistent
    max-width="600px"
    min-width="360px"
  >
    <v-card class="px-4">
      <v-card-title> Are you sure? </v-card-title>
      <v-card-text>
        Are you sure you want to delete this employee?
      </v-card-text>
      <v-card-actions>
        <v-btn color="success" @click="deleteDialog = false"> Cancel </v-btn>
        <v-spacer></v-spacer>
        <v-btn color="red" @click="() => deleteEmployee()"> Delete </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <DataTable
    theme-color="#1d90ff"
    table-class-name="customize-table"
    buttons-pagination
    v-model:server-options="serverOptions"
    :server-items-length="employee.total"
    :loading="employee.loading"
    :headers="headers"
    :items="employee.items"
    hide-rows-per-page
    must-sort
  >
    <template #item-actions="item">
      <div class="d-flex justify-between">
        <v-btn
          size="x-small"
          class="mr-2"
          color="red darken-3"
          icon="mdi-delete"
          @click="() => showDeleteDialog(item.uuid)"
        ></v-btn>
        <v-btn
          size="x-small"
          icon="mdi-pencil"
          @click="
            () =>
              $router.push({
                path: `/employees/${item.uuid}`,
              })
          "
        ></v-btn>
      </div>
    </template>
  </DataTable>
</template>
<script>
import "@/assets/datatable.css";
import { useEmployeeStore } from "@/stores/employees";

export default {
  setup: () => {
    const employee = useEmployeeStore();
    return { employee };
  },
  data: () => ({
    headers: [
      { text: "Firt Name", value: "first_name" },
      { text: "Last Name", value: "last_name", sortable: true },
      { text: "Actions", value: "actions" },
    ],
    serverOptions: {
      page: 1,
      // This library doesn't allow you to use rowsPerPage as a prop when you have serverOptions
      // For now this is hardcoded
      rowsPerPage: 2,
      sortBy: "last_name",
      sortType: "asc",
    },
    selectedEmployeeUUID: "",
    deleteDialog: false,
  }),
  async beforeMount() {
    await this.employee.get(this.serverOptions);
  },
  watch: {
    serverOptions: {
      handler() {
        this.employee.get(this.serverOptions);
      },
    },
  },
  methods: {
    showDeleteDialog(employeeUUID) {
      this.selectedEmployeeUUID = employeeUUID;
      this.deleteDialog = true;
    },
    async deleteEmployee() {
      await this.employee.delete(this.selectedEmployeeUUID);
      await this.employee.get(this.serverOptions);
      this.deleteDialog = false;
      this.selectedEmployeeUUID = "";
    },
  },
};
</script>
