<script setup>
import { Link, useForm } from "@inertiajs/vue3";

defineProps({
  canResetPassword: {
    type: Boolean,
  },
});

const form = useForm({
  email: "",
  password: "",
  remember: false,
});

const submit = () => {
  form.post(route("login"), {
    onFinish: () => form.reset("password"),
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
      autocomplete="current-password"
    />
    <p v-show="form.errors.password">{{ form.errors.password }}</p>

    <input
      id="remember"
      name="remember"
      type="checkbox"
      v-model="form.remember"
    />
    <label for="remember">Remember me</label>
    <p v-show="form.errors.remember">{{ form.errors.remember }}</p>

    <Link v-if="canResetPassword" :href="route('password.request')">
      Forgot your password?
    </Link>
    <button type="submit" :disabled="form.processing">Log in</button>
  </form>
</template>
