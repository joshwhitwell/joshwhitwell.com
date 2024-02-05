<script setup>
import TextInput from "@/Components/Inputs/TextInput.vue";
import { Link, useForm } from "@inertiajs/vue3";
const form = useForm({
  name: "",
  email: "",
  password: "",
  password_confirmation: "",
});
const submit = () => {
  form.post(route("register"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <TextInput
      name="name"
      label="Name"
      help="How do you want to be called?"
      required
      autofocus
      autocomplete="name"
      v-model="form.name"
    />
    <TextInput
      name="email"
      label="Email"
      type="email"
      help="How can we reach you?"
      required
      autocomplete="username"
      v-model="form.email"
    />
    <TextInput
      name="password"
      label="Password"
      type="password"
      help="Keep it secret, keep it safe."
      required
      autocomplete="new-password"
      v-model="form.password"
    />
    <TextInput
      name="password_confirmation"
      label="Confirm Password"
      type="password"
      help="Just to be sure."
      required
      autocomplete="new-password"
      v-model="form.password_confirmation"
    />
    <button type="submit" :disabled="form.processing">Register</button>
    <Link :href="route('login')"> Already registered? </Link>
  </form>
</template>

<style scoped>
a {
  color: var(--neutral-500);
}
</style>
