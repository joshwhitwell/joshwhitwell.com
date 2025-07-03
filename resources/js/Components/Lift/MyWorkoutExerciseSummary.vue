<script setup>
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  workoutExerciseLog: Object,
});

const page = usePage();

const liftStatus = page.props.liftStatus;
</script>

<template>
  <summary class="exercise-summary">
    <h2 class="exercise-name">
      {{ workoutExerciseLog.name }}
    </h2>

    <em>{{
      (() => {
        switch (workoutExerciseLog.status) {
          case liftStatus.Skipped:
            return 'Skipped';
          case liftStatus.InProgress:
            return 'In Progress';
          case liftStatus.Completed:
            return 'Completed';
          case liftStatus.NotStarted:
          default:
            return '';
        }
      })()
    }}</em>
  </summary>
</template>

<style scoped>
.exercise-summary {
  align-items: center;
  display: flex;
  gap: var(--size-3xs);
}

.exercise-name {
  align-items: center;
  display: flex;
  font-size: var(--size-lg);
  column-gap: var(--size-xs);
}
</style>
