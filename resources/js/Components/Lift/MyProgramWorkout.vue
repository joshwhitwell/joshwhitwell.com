<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({ workoutLog: Object, programLog: Object });
</script>

<template>
  <Link
    :href="
      route('lift.my.programs.workouts.edit', [programLog.id, workoutLog.id])
    "
    class="workout-log"
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
  border: 2px solid var(--color-neutral-200);
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
  text-decoration: underline;
  width: 100%;
}

.completed-tag {
  align-items: flex-start;
  border: 2px solid var(--color-lime-500);
  border-radius: var(--size-base);
  color: var(--color-lime-500);
  display: flex;
  font-size: var(--size-base);
  font-weight: 100;
  justify-content: center;
  padding: var(--size-9xs);
  text-decoration: none;
}
</style>
