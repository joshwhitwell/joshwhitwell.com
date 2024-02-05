<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});
const user = usePage().props.auth.user;
const form = useForm({
  name: user.name,
  email: user.email,
});
</script>

<template>
  <section>
    <header>
      <h2>Profile Information</h2>
      <p>Update your account's profile information and email address.</p>
    </header>
    <form @submit.prevent="form.patch(route('profile.update'))">
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
      <div v-if="mustVerifyEmail && user.email_verified_at === null">
        <p>Your email address is unverified.</p>
        <Link :href="route('verification.send')" method="post" as="button">
          Re-send the verification email.
        </Link>
        <p v-show="status === 'verification-link-sent'">
          A new verification link has been sent to your email address.
        </p>
      </div>
      <button type="submit" :disabled="form.processing">Save</button>
      <p v-if="form.recentlySuccessful">Saved.</p>
    </form>
  </section>
</template>
