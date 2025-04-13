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

    <h1>{{ workoutLog.name }}</h1>

    <form @submit.prevent="submitCompletedAtForm">
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
    >
      <h2>{{ workoutExerciseLog.name }}</h2>

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

        <form>
          <label :for="'reps_' + setLog.id">Reps</label>
          <input
            :id="'reps_' + setLog.id"
            name="reps"
            v-model="setLogForms[setLog.id].reps"
          />

          <label :for="'weight_' + setLog.id">Weight</label>
          <input
            :id="'weight_' + setLog.id"
            name="weight"
            v-model="setLogForms[setLog.id].weight"
          />

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

          <ul v-if="setLogForms[setLog.id].errors">
            <li
              v-for="(error, index) in setLogForms[setLog.id].errors"
              :key="`error-${setLog.id}-${index}`"
            >
              {{ error }}
            </li>
          </ul>
        </form>
      </div>
    </div>
  </div>
</template>
