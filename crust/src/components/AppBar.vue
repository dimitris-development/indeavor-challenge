<template>
  <v-app-bar :elevation="2">
    <v-app-bar-title>Indeavor Employee Management</v-app-bar-title>

    <v-spacer></v-spacer>
    <v-btn v-if="!isHome" icon>
      <v-icon icon="mdi-home" @click="$router.push('/')" />
    </v-btn>
    <v-btn icon>
      <v-icon icon="mdi-logout-variant" @click="() => auth.logout()" />
    </v-btn>
  </v-app-bar>
</template>
<script>
import { useAuthStore } from "@/stores/auth";

export default {
  setup: () => {
    const auth = useAuthStore();
    return { auth };
  },
  computed: {
    isHome() {
      return this.$route.path === "/";
    },
  },
};
</script>
