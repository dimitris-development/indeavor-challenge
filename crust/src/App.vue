<script setup>
import { RouterView } from "vue-router";
import { mapState } from "pinia";
import { useAuthStore } from "@/stores/auth";
</script>

<template>
  <v-app>
    <v-main>
      <RouterView />
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: "App",
  computed: {
    ...mapState(useAuthStore, {
      loggedIn: (user) => !!user.token,
    }),
  },
};
</script>
