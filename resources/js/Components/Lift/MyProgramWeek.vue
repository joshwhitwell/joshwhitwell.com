<script setup>
import MyProgramWorkout from './MyProgramWorkout.vue';
import { usePage } from '@inertiajs/vue3';

defineProps({ weekLog: Object, programLog: Object });

const page = usePage();

const liftStatus = page.props.liftStatus;
</script>

<template>
  <details
    :open="
      weekLog.workoutLogs.some(
        (workoutLog) =>
          workoutLog.status === liftStatus.NotStarted ||
          workoutLog.status === liftStatus.InProgress
      )
    "
    class="week-details"
  >
    <summary>
      <h3 class="week-name">
        {{ weekLog.name }}
        <small
          v-if="
            weekLog.status === liftStatus.Completed ||
            weekLog.workoutLogs.every(
              (workoutLog) =>
                workoutLog.status === liftStatus.Completed ||
                workoutLog.status === liftStatus.Skipped
            )
          "
          class="completed-tag"
        >
          <span class="material-symbols-outlined"> check </span>
        </small>
      </h3>
    </summary>

    <div class="workout-logs">
      <MyProgramWorkout
        v-for="workoutLog in weekLog.workoutLogs"
        :key="`workout-log--${workoutLog.id}`"
        :program-log="programLog"
        :workout-log="workoutLog"
      />
    </div>
  </details>
</template>

<style scoped>
.week-details {
  border: 2px solid var(--color-neutral-200);
  border-radius: var(--size-base);
  margin-block-end: var(--size-xl);
}

.week-details summary {
  display: flex;
  list-style: none;
  -webkit-list-style: none;
}

.week-details summary::-webkit-details-marker {
  display: none;
}

.week-name {
  align-items: center;
  display: flex;
  font-size: var(--size-xl);
  justify-content: space-between;
  margin-block: var(--size-xl);
  padding-inline: var(--size-base) calc(var(--size-3xs) + var(--size-base));
  width: 100%;
}

.workout-logs {
  display: flex;
  flex-direction: column;
  padding-inline: var(--size-3xs);
}
</style>
