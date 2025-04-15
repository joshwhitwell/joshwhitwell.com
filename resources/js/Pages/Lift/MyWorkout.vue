<script setup>
import { ref } from 'vue';
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link, router, useForm } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

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
  <div class="page">
    <Link
      :href="route('lift.my.programs.show', programLog.id)"
      class="back-link"
    >
      <span class="material-symbols-outlined"> arrow_back_ios </span>
      Back to program
    </Link>

    <h1 class="page-title">{{ workoutLog.name }}</h1>

    <form @submit.prevent="submitCompletedAtForm" class="mark-complete-form">
      <p v-if="workoutLog.completedAt">
        <em>Completed on </em> {{ workoutLog.completedAt }}
      </p>

      <button type="submit">
        {{ workoutLog.completedAt ? 'Undo' : 'Complete' }}
      </button>
    </form>

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
  </div>
</template>

<style scoped>
.font-monospace {
  font-family: monospace;
}

.page {
  padding: 0 8px;
}

.page * {
  max-width: 65ch;
}

.back-link {
  align-items: center;
  display: flex;
  color: var(--color-lime-500);
  margin: var(--font-size-p) 0 0;
  text-decoration: none;
}

.back-link .material-symbols-outlined {
  font-size: var(--font-size-p);
}

.page-title {
  font-size: var(--font-size-h1);
  margin: var(--font-size-h1) 0 4px;
}

.mark-complete-form {
  margin: 0 0 var(--font-size-h1);
}

.exercise-details {
  margin-bottom: 16px;
}

.exercise-name {
  font-size: var(--font-size-h6);
  margin: 0 0 4px;
}

.exercise-notes {
  font-size: var(--font-size-small);
  margin-bottom: 4px;
}

.rest-string {
  font-size: var(--font-size-small);
}

.exercise-history {
  font-size: var(--font-size-small);
  margin: 16px 0;
}

.exercise-history summary {
  font-size: var(--font-size-p);
}

.exercise-history table {
  margin-top: 4px;
  /* width: 100%; */
}

.past-exercise {
  margin-top: 8px;
}

td:not(:last-child),
th:not(:last-child) {
  padding-right: 16px;
}

.exercise-history td:first-child {
  /* width: 100%; */
}

.exercise-history td:not(:first-child) {
  white-space: nowrap;
  text-align: right;
}

.table-spacer {
  height: 8px;
}

.workout-exercise-log {
  background-color: var(--color-lime-50);
  border-radius: 16px;
  padding: 16px;
  margin-bottom: var(--font-size-h1);
}

.set-log {
  margin-bottom: 16px;
}

.set-log:last-of-type {
  margin-bottom: 0;
}

.set-name {
  font-size: var(--font-size-small);
  margin-bottom: 4px;
}

.set-name small {
  font-size: var(--font-size-small-small);
  font-weight: 400;
  margin-left: 4px;
}

.rep-string {
  font-size: var(--font-size-small-small);
  margin-bottom: 8px;
}

.input-row {
  display: flex;
  align-items: flex-end;
}

label span {
  font-size: var(--font-size-small-small);
  font-weight: 500;
  display: block;
  margin-bottom: 4px;
}

label:first-of-type {
  margin-right: 4px;
}

input {
  border: none;
  border-radius: 16px;
  box-sizing: border-box;
  display: block;
  font-family: monospace;
  padding: 0px 16px;
  height: 40px;
  width: 100%;
}

input:focus,
button:focus {
  outline: 2px solid var(--color-lime-500);
  outline-offset: -1px;
}

.button-group {
  display: flex;
  margin-left: 8px;
}

button {
  background-color: var(--color-lime-500);
  border: none;
  border-radius: 16px;
  color: var(--color-white);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px 16px;
}

.button-outline {
  background-color: transparent;
  border: 2px solid var(--color-lime-400);
  color: var(--color-lime-400);
}

.button-group button {
  height: 40px;
  width: 40px;
}

.button-group button:first-child {
  margin-right: 2px;
}

.material-symbols-outlined {
  font-size: var(--font-size-h5);
}

ul {
  padding: 0;
  margin: 0;
}
</style>
