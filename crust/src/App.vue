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
import AppBar from "@/components/AppBar.vue";

export default {
  setup: () => {
    const auth = useAuthStore();
    return { auth };
  },
  components: {
    AppBar,
  },
  computed: {
    isAuthenticated() {
      return !!this.auth.user?.token;
    },
  },
};
</script>
