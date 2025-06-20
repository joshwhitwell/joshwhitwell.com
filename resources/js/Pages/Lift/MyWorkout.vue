<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import MyWorkoutExercise from './MyWorkoutExercise.vue';

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
  <Layout>
    <template #navigation>
      <Link
        :href="route('lift.my.programs.show', programLogId)"
        class="back-link"
      >
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to program
      </Link>
    </template>

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

    <div v-if="workoutLog.status !== liftStatus.NotStarted">
      <MyWorkoutExercise
        v-for="workoutExerciseLog in workoutLog.workoutExerciseLogs"
        :key="workoutExerciseLog.id"
        :workout-exercise-log="workoutExerciseLog"
        :program-log-id="programLogId"
        :workout-log-id="workoutLog.id"
      />

      <div class="workout-forms">
        <form
          @submit.prevent="
            submitWorkoutStatusForm(
              workoutLog.status === liftStatus.Completed
                ? liftStatus.NotStarted
                : liftStatus.Completed
            )
          "
          class="complete-workout-form"
        >
          <button
            :class="[
              'button',
              'button--outline',
              {
                'button--red': workoutLog.status === liftStatus.Completed,
              },
            ]"
          >
            {{
              workoutLog.status === liftStatus.Completed
                ? 'Mark Workout Incomplete'
                : 'Complete Workout'
            }}
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
    </div>
  </Layout>
</template>

<style scoped>
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

.completed-at {
  margin-block-end: var(--size-3xs);
}

.page-header {
  margin-block-end: var(--size-5xl);
}

.button .material-symbols-outlined {
  font-size: var(--size-xl);
}

.workout-forms {
  display: flex;
  gap: var(--size-5xs);
  margin-block-start: var(--size-3xl);
  margin-block-end: var(--size-5xl);
}
</style>
