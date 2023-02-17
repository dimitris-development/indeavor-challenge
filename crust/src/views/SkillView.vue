<template>
  <v-dialog
    v-model="deleteDialog"
    persistent
    max-width="600px"
    min-width="360px"
  >
    <v-card class="px-4">
      <v-card-title> Are you sure? </v-card-title>
      <v-card-text> Are you sure you want to delete this skill? </v-card-text>
      <v-card-actions>
        <v-btn color="success" @click="deleteDialog = false"> Cancel </v-btn>
        <v-spacer></v-spacer>
        <v-btn color="red" @click="() => deleteSkill()"> Delete </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
  <DataTable
    theme-color="#1d90ff"
    table-class-name="customize-table"
    buttons-pagination
    v-model:server-options="serverOptions"
    :server-items-length="skill.total"
    :loading="skill.loading"
    :headers="headers"
    :items="skill.items"
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
        <v-btn size="x-small" icon="mdi-pencil"></v-btn>
      </div>
    </template>
  </DataTable>
</template>
<script>
import "@/assets/datatable.css";
import { useSkillStore } from "@/stores/skills";

export default {
  setup: () => {
    const skill = useSkillStore();
    return { skill };
  },
  data: () => ({
    headers: [
      { text: "Name", value: "name" },
      { text: "Description", value: "description" },
      { text: "Actions", value: "actions" },
    ],
    serverOptions: {
      page: 1,
      // This library doesn't allow you to use rowsPerPage as a prop when you have serverOptions
      // For now this is hardcoded
      rowsPerPage: 2,
    },
    selectedSkillUUID: "",
    deleteDialog: false,
  }),
  async beforeMount() {
    await this.skill.get(this.serverOptions);
  },
  watch: {
    serverOptions: {
      handler() {
        this.skill.get(this.serverOptions);
      },
    },
  },
  methods: {
    showDeleteDialog(skillUUID) {
      this.selectedSkillUUID = skillUUID;
      this.deleteDialog = true;
    },
    async deleteSkill() {
      await this.skill.delete(this.selectedSkillUUID);
      await this.skill.get(this.serverOptions);
      this.deleteDialog = false;
      this.selectedSkillUUID = "";
    },
  },
};
</script>
