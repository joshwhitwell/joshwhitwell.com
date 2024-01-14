<script setup>
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
  password: "",
});

const confirmUserDeletion = () => {
  confirmingUserDeletion.value = true;

  nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
  form.delete(route("profile.destroy"), {
    preserveScroll: true,
    onError: () => passwordInput.value.focus(),
    onFinish: () => form.reset(),
  });
};
</script>

<template>
  <section>
    <header>
      <h2>Delete Account</h2>

      <p>
        Once your account is deleted, all of its resources and data will be
        permanently deleted. Before deleting your account, please download any
        data or information that you wish to retain.
      </p>
    </header>

    <button
      v-show="!confirmingUserDeletion"
      type="button"
      @click="confirmUserDeletion"
    >
      Delete Account
    </button>

    <div v-show="confirmingUserDeletion">
      <h2>Are you sure you want to delete your account?</h2>

      <p>
        Once your account is deleted, all of its resources and data will be
        permanently deleted. Please enter your password to confirm you would
        like to permanently delete your account.
      </p>

      <label for="delete_password">Password</label>
      <input
        id="delete_password"
        name="delete_password"
        type="password"
        v-model="form.password"
        required
        ref="passwordInput"
      />
      <p v-show="form.errors.password">{{ form.errors.password }}</p>

      <button type="button" @click="confirmingUserDeletion = false">
        Cancel
      </button>
      <button type="submit" @click="deleteUser" :disabled="form.processing">
        Delete Account
      </button>
    </div>
  </section>
</template>
