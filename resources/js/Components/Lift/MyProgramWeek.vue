<script setup>
import MyProgramWorkout from './MyProgramWorkout.vue';

defineProps({ weekLog: Object, programLog: Object });
</script>

<template>
  <details
    :open="weekLog.workoutLogs.some((workoutLog) => !workoutLog.completedAt)"
    class="week-details"
  >
    <summary>
      <h3 class="week-name">
        {{ weekLog.name }}
        <small
          v-if="
            weekLog.completedAt ||
            weekLog.workoutLogs.every((workoutLog) => workoutLog.completedAt)
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
  list-style: none;
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
  padding-inline: var(--size-3xs);
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
