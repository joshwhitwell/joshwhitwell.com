<script setup>
import CheckboxInput from "@/Components/Inputs/CheckboxInput.vue";
import TextInput from "@/Components/Inputs/TextInput.vue";
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
    <TextInput
      name="email"
      label="Who are you?"
      help="Don’t think too hard about this one."
      :autofocus="true"
      autocomplete="username"
      :error="form.errors.email"
      v-model="form.email"
    />
    <TextInput
      name="password"
      type="password"
      label="How do I know it’s you?"
      help="Prove to me you are who you say you are."
      autocomplete="current-password"
      :error="form.errors.password"
      v-model="form.password"
    />
    <CheckboxInput
      name="remember"
      label="Come here often?"
      help="I’ll remember you for next time."
      :error="form.errors.remember"
      v-model="form.remember"
    />

    <Link v-if="canResetPassword" :href="route('password.request')">
      Forgot your password?
    </Link>
    <button type="submit" :disabled="form.processing">Enter</button>
  </form>
</template>
