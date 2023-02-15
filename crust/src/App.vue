<script setup>
import { RouterView } from 'vue-router'
import { mapState } from 'pinia'
import { useAuthStore } from './stores/auth'
</script>

<template>
  <v-app>
    <SideBar v-if="loggedIn"/>
    <v-main>
      <RouterView />
    </v-main>
  </v-app>
</template>

<script>
import SideBar from './components/SideBar.vue'

export default {
  name: 'App',
  components: {
    SideBar
  },
  computed: {
    ...mapState(useAuthStore, {
      loggedIn: (user) => !!user.token
    })
  }
}

</script>