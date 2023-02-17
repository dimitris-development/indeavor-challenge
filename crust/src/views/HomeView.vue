<template>
  <v-container fluid>
    <v-row dense>
      <v-col md="6" lg="4" v-for="card in cards">
        <v-card
          v-ripple
          :title="card.title"
          :subtitle="card.subtitle"
          :text="card.text"
          @click="() => $router.push({ name: card.routeName })"
        ></v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
<script>
export default {
  data: () => ({
    cards: [
      {
        title: "Employees",
        subtitle: "Employee Management",
        text: "Click here to manage employees",
        routeName: "employees",
      },
      {
        title: "Skills",
        subtitle: "Skill Management",
        text: "Click here to manage skills",
        routeName: "skills",
      },
    ],
  }),
};
</script>
