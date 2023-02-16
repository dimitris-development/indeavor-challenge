<script setup>
import { RouterView } from "vue-router";
import { mapState } from "pinia";
</script>

<template>
  <v-app>
    <v-main>
      <RouterView />
    </v-main>
  </v-app>
</template>
