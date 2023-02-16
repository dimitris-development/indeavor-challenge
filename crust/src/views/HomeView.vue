<template>
  <v-container fluid>
    <v-row dense>
      <v-col md="6" lg="4">
        <v-card
          v-ripple
          title="Employees"
          subtitle="Employee Management"
          text="Click here to manage employees"
          @click="() => $router.push({ name: 'employees' })"
        ></v-card>
      </v-col>
    </v-row>
  </v-container>
</template>
