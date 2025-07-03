<script setup>
import { router, usePage } from '@inertiajs/vue3';

const props = defineProps({
  programLogId: Number,
  workoutLogId: Number,
  workoutExerciseLog: Object,
});

const page = usePage();

const liftStatus = page.props.liftStatus;

function submitExerciseStatusForm(status, exerciseLogId) {
  router.post(
    route('lift.my.programs.workouts.exercises.update', [
      props.programLogId,
      props.workoutLogId,
      exerciseLogId,
    ]),
    {
      _method: 'put',
      status,
    },
    {
      preserveScroll: true,
    }
  );
}
</script>

<template>
  <!-- Not Started -->
  <div
    v-if="workoutExerciseLog.status === liftStatus.NotStarted"
    class="exercise-forms"
  >
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.InProgress, workoutExerciseLog.id)
      "
    >
      <button type="submit" class="button button--outline">Start</button>
    </form>
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.Skipped, workoutExerciseLog.id)
      "
    >
      <button type="submit" class="button button--outline button--blue">
        Skip
      </button>
    </form>
  </div>

  <!-- In Progress -->
  <div
    v-else-if="workoutExerciseLog.status === liftStatus.InProgress"
    class="exercise-forms"
  >
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.Completed, workoutExerciseLog.id)
      "
      class="exercise-form"
    >
      <button class="button button--outline">Complete</button>
    </form>
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.Skipped, workoutExerciseLog.id)
      "
      class="exercise-form"
    >
      <button type="submit" class="button button--blue button--outline">
        Skip
      </button>
    </form>
  </div>

  <!-- Skipped -->
  <div
    v-else-if="workoutExerciseLog.status === liftStatus.Skipped"
    class="exercise-forms"
  >
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.Completed, workoutExerciseLog.id)
      "
    >
      <button type="submit" class="button button--outline">Complete</button>
    </form>
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.NotStarted, workoutExerciseLog.id)
      "
    >
      <button type="submit" class="button button--outline button--red">
        Mark Incomplete
      </button>
    </form>
  </div>

  <!-- Completed -->
  <div
    v-else-if="workoutExerciseLog.status === liftStatus.Completed"
    class="exercise-forms"
  >
    <form
      @submit.prevent="
        submitExerciseStatusForm(liftStatus.NotStarted, workoutExerciseLog.id)
      "
    >
      <button type="submit" class="button button--outline button--red">
        Mark Incomplete
      </button>
    </form>
  </div>
</template>

<style scoped>
.exercise-forms {
  display: flex;
  gap: var(--size-5xs);
  margin-block-start: var(--size-base);
}
</style>
