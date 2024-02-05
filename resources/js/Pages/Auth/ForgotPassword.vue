<script setup>
import { useForm } from "@inertiajs/vue3";
const form = useForm({
  email: "",
});
const submit = () => {
  form.post(route("password.email"));
};
</script>

<template>
  <div>
    Forgot your password? No problem. Just let us know your email address and we
    will email you a password reset link that will allow you to choose a new
    one.
  </div>
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
    <p v-show="form.errors.email">{{ form.errors.username }}</p>
    <button type="submit" :disabled="form.processing">
      Email Password Reset Link
    </button>
  </form>
</template>
