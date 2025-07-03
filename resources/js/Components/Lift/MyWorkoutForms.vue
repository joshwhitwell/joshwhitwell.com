<script setup>
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
  programLogId: Number,
  workoutLog: Object,
});

const page = usePage();

const liftStatus = page.props.liftStatus;

function submitWorkoutStatusForm(status) {
  router.post(
    route('lift.my.programs.workouts.update', [
      props.programLogId,
      props.workoutLog.id,
    ]),
    {
      _method: 'put',
      status,
    },
    {
      preserveState: false,
    }
  );
}
</script>

<template>
  <div v-if="workoutLog.status !== liftStatus.NotStarted" class="workout-forms">
    <!-- In Progress / Skipped -->
    <form
      v-if="
        workoutLog.status === liftStatus.InProgress ||
        workoutLog.status === liftStatus.Skipped
      "
      @submit.prevent="submitWorkoutStatusForm(liftStatus.Completed)"
      class="complete-workout-form"
    >
      <button class="button button--outline">Complete Workout</button>
    </form>

    <!-- Completed / Skipped -->
    <form
      v-if="
        workoutLog.status === liftStatus.Completed ||
        workoutLog.status === liftStatus.Skipped
      "
      @submit.prevent="submitWorkoutStatusForm(liftStatus.NotStarted)"
      class="complete-workout-form"
    >
      <button class="button button--outline button--red">
        Mark Workout Incomplete
      </button>
    </form>

    <!-- Not Completed / Not Skipped -->
    <form
      v-if="
        workoutLog.status !== liftStatus.Completed &&
        workoutLog.status !== liftStatus.Skipped
      "
      @submit.prevent="submitWorkoutStatusForm(liftStatus.Skipped)"
      class="complete-workout-form"
    >
      <button type="submit" class="button button--blue button--outline">
        Skip Workout
      </button>
    </form>
  </div>
</template>

<style scoped>
.workout-forms {
  display: flex;
  gap: var(--size-5xs);
  margin-block-start: var(--size-3xl);
  margin-block-end: var(--size-5xl);
}
</style>
