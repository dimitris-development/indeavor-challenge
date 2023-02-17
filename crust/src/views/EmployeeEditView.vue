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
  </v-form>
</template>
<script>
import { useEmployeeStore } from "@/stores/employees";
import { useSkillStore } from "@/stores/skills";

export default {
  data: () => ({
    valid: true,
    attachedSkills: [],
    skillLoading: false,
    initialLoad: true,
  }),
  setup: () => {
    const employee = useEmployeeStore();
    const skills = useSkillStore();
    return { employee, skills };
  },
  async beforeMount() {
    this.skillLoading = true;
    const employeeUUID = this.$route.params["employeeUUID"];
    await this.skills.get({ dontPaginate: true });
    await this.employee.getOne(employeeUUID);

    this.attachedSkills = this.employee.item.skills.map((skill) => skill.uuid);
    this.skillLoading = false;
  },
  watch: {
    async attachedSkills(newSkills, oldSkills) {
      if (this.initialLoad) {
        this.initialLoad = !this.initialLoad;
        return;
      }

      const updatedSkill = this.symmetricDifference(
        new Set(oldSkills),
        new Set(newSkills)
      )[0];

      const updateType =
        oldSkills.length > newSkills.length ? "detach" : "attach";

      await this.employee.updateSkill(
        this.employee.item.uuid,
        updatedSkill,
        updateType
      );
    },
  },
  methods: {
    symmetricDifference(array1, array2) {
      const diff = new Set(array1);

      for (const elem of array2) {
        const operation = diff.has(elem) ? "delete" : "add";
        diff[operation](elem);
      }

      return [...diff];
    },
  },
};
</script>
