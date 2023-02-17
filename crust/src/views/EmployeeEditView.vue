<template>
  <v-form ref="form" fast-fail v-model="valid">
    <v-text-field
      v-model="employee.item.first_name"
      label="First name"
      required
    ></v-text-field>

    <v-text-field
      v-model="employee.item.last_name"
      label="Last name"
      required
    ></v-text-field>

    <span class="text-h6 mb-2"> Skills </span>

    <v-chip-group v-model="attachedSkills" column multiple filter>
      <v-chip
        v-for="skill in skills.items"
        :key="skill.uuid"
        :value="skill.uuid"
        variant="outlined"
      >
        {{ skill.name }}
      </v-chip>
    </v-chip-group>
  </v-form>
</template>
<script>
import { useEmployeeStore } from "@/stores/employees";
import { useSkillStore } from "@/stores/skills";

export default {
  data: () => ({
    valid: true,
  }),
  setup: () => {
    const employee = useEmployeeStore();
    const skills = useSkillStore();
    return { employee, skills };
  },
  computed: {
    attachedSkills() {
      return this.employee.item.skills.map((skill) => skill.uuid);
    },
  },
  async beforeMount() {
    const employeeUUID = this.$route.params["employeeUUID"];
    await this.skills.get({ dontPaginate: true });
    await this.employee.getOne(employeeUUID);
  },
};
</script>
