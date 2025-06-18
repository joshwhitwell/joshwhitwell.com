<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import LiftLayout from '../../../../Layouts/Lift/LiftLayout.vue';

const props = defineProps({
  program: {
    type: Object,
  },
});

const form = useForm({
  name: props.program.name,
});

function submit() {
  if (props.program.id) {
    form.put(route('lift.admin.programs.update', props.program.id));
  } else {
    form.post(route('lift.admin.programs.store'));
  }
}
</script>

<template>
  <LiftLayout>
    <Link :href="route('lift.admin.programs.index')">Back to Programs</Link>
    <form @submit.prevent="submit">
      <div>
        <label for="name">Name</label>
        <input id="name" v-model="form.name" type="text" />
        <div v-if="form.errors.name">
          {{ form.errors.name }}
        </div>
      </div>
      <button type="submit" :disabled="form.processing">Save</button>
    </form>
  </LiftLayout>
</template>
