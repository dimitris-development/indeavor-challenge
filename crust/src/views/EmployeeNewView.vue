<template>
  <v-form ref="form" fast-fail v-model="valid">
    <v-text-field
      v-model="details.first_name"
      label="First name"
      required
    ></v-text-field>

    <v-text-field v-model="details.last_name" label="Last name" required>
    </v-text-field>

    <span class="text-h6 mb-2"> Skills </span>

    <v-chip-group
      v-model="attachedSkills"
      column
      multiple
      filter
      :disabled="skillLoading"
    >
      <v-chip
        v-for="skill in skills.items"
        :key="skill.uuid"
        :value="skill.uuid"
        variant="outlined"
      >
        {{ skill.name }}
      </v-chip>
    </v-chip-group>

    <div class="d-flex justify-between mt-5">
      <v-btn @click="() => $router.push({ name: 'employees' })"> Back </v-btn>
      <v-btn
        :disabled="!valid"
        color="success"
        class="ml-2"
        @click="() => this.employee.create(details, attachedSkills)"
      >
        Create
      </v-btn>
    </div>
  </v-form>
</template>
<script>
import { useEmployeeStore } from "@/stores/employees";
import { useSkillStore } from "@/stores/skills";

export default {
  data: () => ({
    valid: true,
    details: {
      first_name: "",
      last_name: "",
    },
    attachedSkills: [],
    skillLoading: false,
  }),
  setup: () => {
    const employee = useEmployeeStore();
    const skills = useSkillStore();
    return { employee, skills };
  },
  async beforeMount() {
    this.skillLoading = true;
    await this.skills.get({ dontPaginate: true });
    this.skillLoading = false;
  },
};
</script>
