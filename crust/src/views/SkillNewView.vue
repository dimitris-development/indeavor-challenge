<template>
  <v-form ref="form" fast-fail v-model="valid">
    <v-text-field v-model="details.name" label="Name" required></v-text-field>

    <v-textarea v-model="details.description" label="Description" required>
    </v-textarea>

    <div class="d-flex justify-between mt-5">
      <v-btn @click="() => $router.push({ name: 'skills' })"> Back </v-btn>
      <v-btn
        :disabled="!valid"
        color="success"
        class="ml-2"
        @click="() => this.skills.create(details)"
      >
        Create
      </v-btn>
    </div>
  </v-form>
</template>
<script>
import { useSkillStore } from "@/stores/skills";

export default {
  data: () => ({
    valid: true,
    details: {
      name: "",
      description: "",
    },
  }),
  setup: () => {
    const skills = useSkillStore();
    return { skills };
  },
};
</script>
