<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ workoutLog: Object, programLog: Object });
</script>

<template>
  <Link
    :href="
      route('lift.my.programs.workouts.edit', [programLog.id, workoutLog.id])
    "
    class="workout-log lift-background-gradient"
  >
    <h4 class="workout-name">
      {{ workoutLog.name }}
    </h4>
    <small v-if="workoutLog.completedAt" class="completed-tag">
      <span class="material-symbols-outlined"> check </span>
    </small>
  </Link>
</template>

<style scoped>
.workout-log {
  background-color: var(--color-neutral-50);
  border-radius: var(--size-base);
  display: flex;
  margin-block-end: var(--size-base);
  padding: var(--size-base);
  text-decoration: none;
}

.workout-name {
  align-items: center;
  display: flex;
  justify-content: space-between;
  width: 100%;
}
</style>
