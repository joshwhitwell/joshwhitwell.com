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
    <Link :href="route('lift.my.programs.show', programLog.id)">
      {{ programLog.name }}
    </Link>

    <h1 class="page-title">{{ workoutLog.name }}</h1>

    <form @submit.prevent="submitCompletedAtForm" class="mark-complete-form">
      <p v-if="workoutLog.completedAt">
        <em>Completed on </em> {{ workoutLog.completedAt }}
      </p>

      <button type="submit">
        {{ workoutLog.completedAt ? 'Undo' : 'Mark Complete' }}
      </button>
    </form>

    <div
      v-for="workoutExerciseLog in workoutLog.workoutExerciseLogs"
      :key="workoutExerciseLog.id"
      class="workout-exercise-log"
    >
      <h2 class="exercise-name">{{ workoutExerciseLog.name }}</h2>

      <p v-if="workoutExerciseLog.notes" class="exercise-notes">
        {{ workoutExerciseLog.notes }}
      </p>

      <details v-if="workoutExerciseLog.pastLogs.length">
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
              v-for="(pastExerciseLog, index) in workoutExerciseLog.pastLogs"
              :key="pastExerciseLog.id"
            >
              <template v-if="index > 0">
                <tr>
                  <td colspan="3"></td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                </tr>
              </template>

              <tr v-for="setLog in pastExerciseLog.setLogs" :key="setLog.id">
                <td>
                  {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
                  {{ setLog.order }}
                </td>
                <td style="text-align: right">{{ setLog.reps ?? '-' }}</td>
                <td style="text-align: right">{{ setLog.weight ?? '-' }}</td>
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

            <button type="button" @click="setLogForms[setLog.id]?.reset()">
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
.page {
  padding: 0 8px;
}

.page-title {
  font-size: var(--font-size-h1);
  margin: var(--font-size-h1) 0 4px;
}

.mark-complete-form {
  margin: 0 0 var(--font-size-h1);
}

.exercise-name {
  font-size: var(--font-size-h6);
  margin: 0 0 4px;
}

.exercise-notes {
  font-size: var(--font-size-small);
}

details {
  margin: 16px 0;
}

.workout-exercise-log {
  background-color: var(--color-neutral-100);
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

.button-group {
  display: flex;
  margin-left: 8px;
}

button {
  background-color: var(--color-neutral-200);
  border: none;
  border-radius: 16px;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 8px 16px;
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
