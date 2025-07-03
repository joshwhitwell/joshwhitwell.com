<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MyWorkoutExerciseSummary from '../../Components/Lift/MyWorkoutExerciseSummary.vue';
import MyWorkoutExerciseHelp from '../../Components/Lift/MyWorkoutExerciseHelp.vue';
import MyWorkoutExerciseHistory from '../../Components/Lift/MyWorkoutExerciseHistory.vue';
import MyWorkoutExerciseSetLog from '../../Components/Lift/MyWorkoutExerciseSetLog.vue';
import MyWorkoutExerciseForms from '../../Components/Lift/MyWorkoutExerciseForms.vue';

const props = defineProps({
  programLogId: Number,
  workoutLogId: Number,
  workoutExerciseLog: Object,
  isPreviewing: Boolean,
});

const page = usePage();

const liftStatus = page.props.liftStatus;

const totalWarmUps = computed(
  () =>
    props.workoutExerciseLog?.setLogs?.filter((setLog) => setLog?.isWarmUp)
      ?.length || 0
);
</script>

<template>
  <div class="my-workout-exercise">
    <div
      :class="[
        'workout-exercise-container',
        {
          'workout-exercise-container--open':
            workoutExerciseLog.status === liftStatus.InProgress,
        },
      ]"
    >
      <details
        :open="
          isPreviewing || workoutExerciseLog.status === liftStatus.InProgress
        "
      >
        <MyWorkoutExerciseSummary :workout-exercise-log="workoutExerciseLog" />

        <MyWorkoutExerciseHelp :workout-exercise-log="workoutExerciseLog" />

        <MyWorkoutExerciseHistory :workout-exercise-log="workoutExerciseLog" />

        <MyWorkoutExerciseSetLog
          v-for="setLog in workoutExerciseLog.setLogs"
          :key="setLog.id"
          :setLog="setLog"
          :total-warm-ups="totalWarmUps"
          :is-previewing="isPreviewing"
        />
      </details>

      <MyWorkoutExerciseForms
        v-if="!isPreviewing"
        :program-log-id="programLogId"
        :workout-log-id="workoutLogId"
        :workout-exercise-log="workoutExerciseLog"
      />
    </div>
  </div>
</template>

<style scoped>
.my-workout-exercise {
  background-color: var(--color-lime-100);
  border-radius: var(--size-base);
  padding: var(--size-base);
  margin-block-end: var(--size-5xl);
}
</style>
