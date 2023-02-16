<template>
  <v-app>
    <v-layout>
      <AppBar v-if="isAuthenticated" />

      <v-main>
        <RouterView />
      </v-main>
    </v-layout>
  </v-app>
</template>
<script>
import { RouterView } from "vue-router";
import { useAuthStore } from "@/stores/auth";
import { mapState } from "pinia";
import AppBar from "@/components/AppBar.vue";

export default {
  components: {
    AppBar,
  },
  computed: {
    ...mapState(useAuthStore, {
      isAuthenticated: (state) => !!state.user?.token,
    }),
  },
};
</script>
