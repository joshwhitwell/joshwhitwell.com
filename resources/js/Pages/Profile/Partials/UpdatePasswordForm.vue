<script setup>
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
  current_password: "",
  password: "",
  password_confirmation: "",
});

const updatePassword = () => {
  form.put(route("password.update"), {
    preserveScroll: true,
    onSuccess: () => form.reset(),
    onError: () => {
      if (form.errors.password) {
        form.reset("password", "password_confirmation");
        passwordInput.value.focus();
      }
      if (form.errors.current_password) {
        form.reset("current_password");
        currentPasswordInput.value.focus();
      }
    },
  });
};
</script>

<template>
  <section>
    <header>
      <h2>Update Password</h2>

      <p>
        Ensure your account is using a long, random password to stay secure.
      </p>
    </header>

    <form @submit.prevent="updatePassword">
      <label for="current_password">Current Password</label>
      <input
        id="current_password"
        name="current_password"
        type="password"
        v-model="form.current_password"
        required
        autocomplete="current-password"
        ref="currentPasswordInput"
      />
      <p v-show="form.errors.current_password">
        {{ form.errors.current_password }}
      </p>

      <label for="password">New Password</label>
      <input
        id="password"
        name="password"
        type="password"
        v-model="form.password"
        required
        autocomplete="new-password"
        ref="passwordInput"
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

      <button type="submit" :disabled="form.processing">Save</button>
      <p v-if="form.recentlySuccessful">Saved.</p>
    </form>
  </section>
</template>
