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
  <div>
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

      <template v-if="workoutExerciseLog.pastLogs.length">
        <details>
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
      </template>

      <div v-for="setLog in workoutExerciseLog.setLogs" :key="setLog.id">
        <h3>
          {{ setLog.isWarmUp ? 'Warm Up' : 'Set' }}
          {{ setLog.order }}

          <small v-if="setLog.isOptional">(Optional)</small>
        </h3>

        <div class="input-row">
          <label :for="'reps_' + setLog.id">
            Reps
            <input
              :id="'reps_' + setLog.id"
              name="reps"
              v-model="setLogForms[setLog.id].reps"
              class="row-2"
            />
          </label>

          <label :for="'weight_' + setLog.id">
            Weight
            <input
              :id="'weight_' + setLog.id"
              name="weight"
              v-model="setLogForms[setLog.id].weight"
              class="row-2"
            />
          </label>

          <div class="button-group">
            <button
              v-if="
                setLogForms[setLog.id].isDirty &&
                !setLogForms[setLog.id].processing
              "
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
              Save
            </button>

            <button
              v-if="
                setLogForms[setLog.id].isDirty &&
                !setLogForms[setLog.id].processing
              "
              type="button"
              @click="setLogForms[setLog.id]?.reset()"
            >
              Cancel
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

<style>
.page-title {
  font-size: var(--font-size-h1);
  margin: var(--font-size-h1) 0 4px;
}

.mark-complete-form {
  margin: 0 0 var(--font-size-h1);
}

.workout-exercise-log {
  background-color: var(--color-neutral-100);
  border-radius: 16px;
  padding: 16px;
  margin-bottom: var(--font-size-h1);
}

.exercise-name {
  font-size: var(--font-size-h6);
  margin: 0 0 4px;
}

.input-row {
  display: flex;
  align-items: flex-end;
}

label {
  font-size: var(--font-size-small-small);
  align-self: end;
}

input {
  border: none;
  border-radius: 16px;
  display: block;
  font-family: monospace;
  margin-right: 4px;
  padding: 8px 16px;
}

.button-group {
  margin-left: 8px;
}

button {
  background-color: var(--color-neutral-200);
  border: none;
  border-radius: 16px;
  padding: 8px 16px;
  margin-right: 2px;
}
</style>
