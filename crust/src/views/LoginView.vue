<template>
  <v-dialog v-model="dialog" persistent max-width="600px" min-width="360px">
    <v-card class="px-4">
      <v-card-title> Login </v-card-title>

      <v-card-text>
        <v-form ref="form" fast-fail v-model="valid">
          <v-text-field
            v-model="email"
            :rules="emailRules"
            label="E-mail"
            required
          ></v-text-field>

          <v-text-field
            class="mt-2"
            v-model="password"
            type="password"
            label="Password"
            required
          ></v-text-field>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-btn
          x-large
          block
          :disabled="!valid"
          color="success"
          @click="() => auth.login(email, password)"
        >
          Login
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import { useAuthStore } from "@/stores/auth";

export default {
  setup: () => {
    const auth = useAuthStore();
    return { auth };
  },
  data: () => ({
    dialog: true,
    email: "",
    password: "",
    emailRules: [
      (v) => !!v || "Required",
      (v) => /.+@.+\..+/.test(v) || "E-mail must be valid",
    ],
    passwordShow: false,
    valid: false,
  }),
};
</script>
