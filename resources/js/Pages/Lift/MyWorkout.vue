<script setup>
import { Link, router, usePage } from '@inertiajs/vue3';
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import MyWorkoutExercise from './MyWorkoutExercise.vue';
import MyWorkoutHeader from '../../Components/Lift/MyWorkoutHeader.vue';
import MyWorkoutForms from '../../Components/Lift/MyWorkoutForms.vue';

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

    <MyWorkoutHeader :program-log-id="programLogId" :workout-log="workoutLog" />

    <MyWorkoutExercise
      v-for="workoutExerciseLog in workoutLog.workoutExerciseLogs"
      :key="workoutExerciseLog.id"
      :workout-exercise-log="workoutExerciseLog"
      :program-log-id="programLogId"
      :workout-log-id="workoutLog.id"
      :is-previewing="workoutLog.status === liftStatus.NotStarted"
    />

    <MyWorkoutForms :program-log-id="programLogId" :workout-log="workoutLog" />
  </Layout>
</template>
