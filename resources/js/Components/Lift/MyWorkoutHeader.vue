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
  <header class="page-header">
    <h1 class="page-title">
      <span v-if="workoutLog.order" class="day-number"
        >Day {{ workoutLog.order }}</span
      >
      {{ workoutLog.name }}
    </h1>
    <div
      v-if="workoutLog.status === liftStatus.NotStarted"
      class="workout-forms"
    >
      <form @submit.prevent="submitWorkoutStatusForm(liftStatus.InProgress)">
        <button type="submit" class="button button--outline">
          Start Workout
        </button>
      </form>
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
    <p
      v-else-if="workoutLog.status === liftStatus.InProgress"
      class="completed-at"
    >
      <em>In Progress</em>
    </p>
    <p
      v-else-if="workoutLog.status === liftStatus.Completed"
      class="completed-at"
    >
      <em>Completed</em>
    </p>
    <p
      v-else-if="workoutLog.status === liftStatus.Skipped"
      class="completed-at"
    >
      <em>Skipped</em>
    </p>
  </header>
</template>

<style scoped>
.page-header {
  margin-block-end: var(--size-5xl);
}

.page-title {
  display: flex;
  flex-direction: column;
  margin-block-end: var(--size-6xs);
}

.day-number {
  color: var(--color-neutral-500);
  font-size: var(--size-base);
  font-weight: 600;
}

.workout-forms {
  display: flex;
  gap: var(--size-5xs);
  margin-block-start: var(--size-3xl);
  margin-block-end: var(--size-5xl);
}

.completed-at {
  margin-block-end: var(--size-3xs);
}
</style>
