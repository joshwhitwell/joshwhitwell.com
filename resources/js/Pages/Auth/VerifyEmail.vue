<script setup>
import { computed } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
  status: {
    type: String,
  },
});

const form = useForm({});

const submit = () => {
  form.post(route("verification.send"));
};

const verificationLinkSent = computed(
  () => props.status === "verification-link-sent"
);
</script>

<template>
  <p>
    Thanks for signing up! Before getting started, could you verify your email
    address by clicking on the link we just emailed to you? If you didn't
    receive the email, we will gladly send you another.
  </p>

  <p v-if="verificationLinkSent">
    A new verification link has been sent to the email address you provided
    during registration.
  </p>

  <form @submit.prevent="submit">
    <button type="submit" :disabled="form.processing">
      Resend Verification Email
    </button>

    <Link :href="route('logout')" method="post" as="button">Log Out</Link>
  </form>
</template>
