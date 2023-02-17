<template>
  <v-form ref="form" fast-fail v-model="valid">
    <v-text-field
      :disabled="detailsLoading"
      v-model="skill.item.name"
      label="Name"
      required
    ></v-text-field>

    <v-textarea
      :disabled="detailsLoading"
      v-model="skill.item.description"
      label="Description"
      required
    >
    </v-textarea>

    <div class="d-flex justify-between mt-5">
      <v-btn @click="() => $router.push({ name: 'skills' })"> Back </v-btn>
      <v-btn
        :disabled="!valid"
        color="success"
        class="ml-2"
        @click="() => updateDetails()"
      >
        Update
      </v-btn>
    </div>
  </v-form>
</template>
<script>
import { useSkillStore } from "@/stores/skills";

export default {
  data: () => ({
    valid: true,
    detailsLoading: false,
  }),
  setup: () => {
    const skill = useSkillStore();
    return { skill };
  },
  async beforeMount() {
    this.detailsLoading = true;
    const skillUUID = this.$route.params["skillUUID"];
    await this.skill.getOne(skillUUID);
    this.detailsLoading = false;
  },
  methods: {
    async updateDetails() {
      this.detailsLoading = true;
      await this.skill.updateDetails(this.skill.item.uuid, this.skill.item);

      this.detailsLoading = false;
    },
  },
};
</script>
