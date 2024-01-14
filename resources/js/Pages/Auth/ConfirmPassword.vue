<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  password: "",
});

const submit = () => {
  form.post(route("password.confirm"), {
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <p>
    This is a secure area of the application. Please confirm your password
    before continuing.
  </p>

  <form @submit.prevent="submit">
    <label for="password">Password</label>
    <input
      id="password"
      name="password"
      type="password"
      v-model="form.password"
      required
      autocomplete="current-password"
      autofocus
    />
    <p v-show="form.errors.password">{{ form.errors.password }}</p>

    <button type="submit" :disabled="form.processing">Confirm</button>
  </form>
</template>
