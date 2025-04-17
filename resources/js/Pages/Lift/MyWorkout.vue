<script setup>
import { ref } from 'vue';
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link, router, useForm } from '@inertiajs/vue3';

const props = defineProps({
  programLog: Object,
  workoutLog: Object,
  liftStatus: Object,
});

function submitCompletedAtForm() {
  router.post(
    route('lift.my.programs.workouts.update', [
      props.programLog.id,
      props.workoutLog.id,
    ]),
    {
      _method: 'put',
      status: props.workoutLog.completedAt
        ? props.liftStatus.NotStarted
        : props.liftStatus.Completed,
    },
    {
      only: ['workoutLog'],
      preserveScroll: true,
    }
  );
}

const setLogForms = ref(
  props?.workoutLog?.workoutExerciseLogs?.reduce?.(
    (setLogForms, workoutExerciseLog) => {
      workoutExerciseLog?.setLogs?.forEach((setLog) => {
        setLogForms[setLog.id] = useForm(setLog);
      });
      return setLogForms;
    },
    {}
  ) || {}
);
</script>

<template>
  <Layout>
    <template #navigation>
      <Link
        :href="route('lift.my.programs.show', programLog.id)"
        class="back-link"
      >
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to program
      </Link>
    </template>

    <header class="page-header">
      <h1 class="page-title">{{ workoutLog.name }}</h1>

      <form @submit.prevent="submitCompletedAtForm">
        <p v-if="workoutLog.completedAt" class="completed-at">
          <em>Completed on </em> {{ workoutLog.completedAt }}
        </p>

        <button type="submit" class="button-outline">
          {{ workoutLog.completedAt ? 'Undo' : 'Complete' }}
        </button>
      </form>
    </header>

    <div
      v-for="workoutExerciseLog in workoutLog.workoutExerciseLogs"
      :key="workoutExerciseLog.id"
      class="workout-exercise-log"
    >
      <div class="exercise-details">
        <h2 class="exercise-name">{{ workoutExerciseLog.name }}</h2>

        <p v-if="workoutExerciseLog.notes" class="exercise-notes">
          {{ workoutExerciseLog.notes }}
        </p>

        <p v-if="workoutExerciseLog.restString" class="rest-string">
          <strong>Rest: </strong> {{ workoutExerciseLog.restString }}
        </p>
      </div>

      <details
        v-if="workoutExerciseLog.pastLogs.length"
        class="exercise-history"
      >
        <summary>History</summary>

        <table style="text-align: left">
          <thead>
            <tr>
              <th>Set</th>
              <th style="text-align: right">Reps</th>
              <th style="text-align: right">Weight</th>
            </tr>
          </thead>

          <tbody>
            <template
              v-for="(
                pastExerciseLog, pastExerciseLogIndex
              ) in workoutExerciseLog.pastLogs"
              :key="pastExerciseLog.id"
            >
              <tr v-if="pastExerciseLogIndex > 0">
                <td colspan="3" class="table-spacer"></td>
              </tr>
              <tr v-for="setLog in pastExerciseLog.setLogs" :key="setLog.id">
                <td>
                  {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
                  {{ setLog.order }}
                </td>
                <td style="text-align: right" class="font-monospace">
                  {{ setLog.reps ?? '-' }}
                </td>
                <td style="text-align: right" class="font-monospace">
                  {{ setLog.weight ?? '-' }}
                </td>
              </tr>
            </template>
          </tbody>
        </table>
      </details>

      <div
        v-for="setLog in workoutExerciseLog.setLogs"
        :key="setLog.id"
        class="set-log"
      >
        <h3 class="set-name">
          {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
          {{ setLog.order }}

          <small v-if="setLog.isOptional">(Optional)</small>
        </h3>

        <p v-if="setLog.repsRpeIntensity" class="rep-string">
          {{ setLog.repsRpeIntensity }}
        </p>

        <div class="input-row">
          <label :for="'reps_' + setLog.id">
            <span>Reps</span>
            <input
              :id="'reps_' + setLog.id"
              name="reps"
              v-model="setLogForms[setLog.id].reps"
              class="row-2"
            />
          </label>

          <label :for="'weight_' + setLog.id">
            <span>Weight</span>
            <input
              :id="'weight_' + setLog.id"
              name="weight"
              v-model="setLogForms[setLog.id].weight"
              class="row-2"
            />
          </label>

          <div
            class="button-group"
            v-if="
              setLogForms[setLog.id].isDirty &&
              !setLogForms[setLog.id].processing
            "
          >
            <button
              type="button"
              @click="
                setLogForms[setLog.id]
                  .transform((data) => ({
                    ...data,
                    _method: 'put',
                  }))
                  .post(route('lift.set-logs.update', setLog.id), {
                    only: [],
                    preserveScroll: true,
                  })
              "
            >
              <span class="material-symbols-outlined"> check </span>
            </button>

            <button
              type="button"
              @click="setLogForms[setLog.id]?.reset()"
              class="button-outline"
            >
              <span class="material-symbols-outlined"> close </span>
            </button>
          </div>

          <ul v-if="setLogForms[setLog.id].errors">
            <li
              v-for="(error, index) in setLogForms[setLog.id].errors"
              :key="`error-${setLog.id}-${index}`"
            >
              {{ error }}
            </li>
          </ul>
        </div>
      </div>
    </div>
  </Layout>
</template>

<style scoped>
.page-title {
  margin-block-end: var(--size-7xs);
}

.completed-at {
  margin-block-end: var(--size-3xs);
}

.page-header {
  margin-block-end: var(--size-5xl);
}

.exercise-details {
  margin-block-end: var(--size-base);
}

.exercise-name {
  font-size: var(--size-lg);
  margin-block-end: var(--size-7xs);
}

.exercise-notes {
  font-size: var(--size-sm);
  margin-block-end: var(--size-3xs);
}

.rest-string {
  font-size: var(--size-sm);
}

.exercise-history {
  font-size: var(--size-sm);
  margin-block-end: var(--size-base);
  margin-block-start: var(--size-base);
}

.exercise-history summary {
  font-size: var(--size-base);
}

.exercise-history table {
  margin-block-start: var(--size-3xs);
}

.past-exercise {
  margin-block-start: var(--size-3xs);
}

td:not(:last-child),
th:not(:last-child) {
  padding-right: var(--size-base);
}

.exercise-history td:not(:first-child) {
  white-space: nowrap;
  text-align: right;
}

.table-spacer {
  height: var(--size-3xs);
}

.workout-exercise-log {
  background-color: var(--color-lime-50);
  border-radius: var(--size-base);
  padding: var(--size-base);
  margin-block-end: var(--size-5xl);
}

.set-log {
  margin-block-end: var(--size-base);
}

.set-log:last-of-type {
  margin-block-end: 0;
}

.set-name {
  font-size: var(--size-sm);
  margin-block-end: var(--size-3xs);
}

.set-name small {
  font-size: var(--size-xs);
  font-weight: 400;
  margin-inline-start: var(--size-3xs);
}

.rep-string {
  font-size: var(--size-xs);
  margin-block-end: var(--size-3xs);
}

.input-row {
  display: flex;
  align-items: flex-end;
}

label span {
  font-size: var(--size-xs);
  font-weight: 500;
  display: block;
  margin-block-end: var(--size-3xs);
}

label:first-of-type {
  margin-inline-end: var(--size-3xs);
}

input {
  border: none;
  border-radius: var(--size-base);
  box-sizing: border-box;
  display: block;
  font-family: monospace;
  padding: 0px var(--size-base);
  height: var(--size-4xl);
  width: 100%;
}

input:focus,
button:focus {
  outline: var(--size-10xs) solid var(--color-lime-500);
}

.button-group {
  display: flex;
  margin-left: var(--size-3xs);
}

button {
  background-color: var(--color-lime-500);
  border: none;
  border-radius: var(--size-base);
  color: var(--color-white);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: var(--size-3xs) var(--size-base);
}

.button-outline {
  background-color: transparent;
  border: var(--size-10xs) solid var(--color-lime-400);
  color: var(--color-lime-400);
  font-weight: 500;
}

.button-group button {
  height: var(--size-4xl);
  width: var(--size-4xl);
}

.button-group button:first-child {
  margin-inline-end: var(--size-10xs);
}

button span.material-symbols-outlined {
  font-size: var(--size-xl);
}

ul {
  padding: 0;
  margin: 0;
}
</style>
