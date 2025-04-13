<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

defineProps({ programLog: Object, workoutLog: Object, liftStatus: Object });
</script>

<template>
  <div>
    <Link :href="route('lift.my.programs.show', programLog.id)">
      {{ programLog.name }}
    </Link>

    <h1>{{ workoutLog.name }}</h1>

    <form
      v-if="workoutLog.completedAt"
      :action="
        route('lift.my.programs.workouts.update', [
          programLog.id,
          workoutLog.id,
        ])
      "
      method="PUT"
    >
      <input
        type="hidden"
        id="status"
        name="status"
        :value="liftStatus.NotStarted"
      />

      <em>Completed on </em> {{ workoutLog.completedAt }}

      <button type="submit">Undo</button>
    </form>
    <form
      v-else
      :action="
        route('lift.my.programs.workouts.update', [
          programLog.id,
          workoutLog.id,
        ])
      "
      method="PUT"
    >
      <input
        type="hidden"
        id="status"
        name="status"
        :value="liftStatus.Completed"
      />

      <button type="submit">Mark Complete</button>
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

        <form :action="route('lift.set-logs.update', setLog)" method="PUT">
          <input
            :id="'reps_' + setLog.id"
            name="reps"
            label="Reps"
            :value="setLog.reps"
          />

          <input
            :id="'weight_' + setLog.id"
            name="weight"
            label="Weight"
            :value="setLog.weight"
          />

          <button type="submit">Save</button>
        </form>
      </div>
    </div>
  </div>
</template>
