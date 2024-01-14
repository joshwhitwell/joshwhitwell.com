<script setup>
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
    <label for="name">Name</label>
    <input
      id="name"
      name="name"
      type="text"
      v-model="form.name"
      required
      autofocus
      autocomplete="name"
    />
    <p v-show="form.errors.name">{{ form.errors.name }}</p>

    <label for="email">Email</label>
    <input
      id="email"
      name="email"
      type="email"
      v-model="form.email"
      required
      autocomplete="username"
    />
    <p v-show="form.errors.email">{{ form.errors.email }}</p>

    <label for="password">Password</label>
    <input
      id="password"
      name="password"
      type="password"
      v-model="form.password"
      required
      autocomplete="new-password"
    />
    <p v-show="form.errors.password">{{ form.errors.password }}</p>

    <label for="password_confirmation">Confirm Password</label>
    <input
      id="password_confirmation"
      name="password_confirmation"
      type="password"
      v-model="form.password_confirmation"
      required
      autocomplete="new-password"
    />
    <p v-show="form.errors.password_confirmation">
      {{ form.errors.password_confirmation }}
    </p>

    <Link :href="route('login')"> Already registered? </Link>

    <button type="submit" :disabled="form.processing">Register</button>
  </form>
</template>
