<script setup>
import { useForm } from "@inertiajs/vue3";

const props = defineProps({
  email: {
    type: String,
    required: true,
  },
  token: {
    type: String,
    required: true,
  },
});

const form = useForm({
  token: props.token,
  email: props.email,
  password: "",
  password_confirmation: "",
});

const submit = () => {
  form.post(route("password.store"), {
    onFinish: () => form.reset("password", "password_confirmation"),
  });
};
</script>

<template>
  <form @submit.prevent="submit">
    <label for="email">Email</label>
    <input
      id="email"
      name="email"
      type="email"
      v-model="form.email"
      required
      autofocus
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

    <button type="submit" :disabled="form.processing">Reset Password</button>
  </form>
</template>
