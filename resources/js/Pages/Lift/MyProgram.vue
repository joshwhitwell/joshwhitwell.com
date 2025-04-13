<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

defineProps({ programLog: Object });
</script>

<template>
  <div>
    <Link
      :href="route('lift.my.programs.index')"
      style="color: blue; text-decoration: none"
    >
      Back to My Programs
    </Link>

    <h1>{{ programLog.name }}</h1>

    <div v-for="phaseLog in programLog.phaseLogs" :key="phaseLog.id">
      <h2>{{ phaseLog.name }}</h2>

      <details
        v-for="weekLog in phaseLog.weekLogs"
        :key="weekLog.id"
        :open="
          weekLog.workoutLogs.some((workoutLog) => !workoutLog.completedAt)
        "
      >
        <summary>
          <h3>{{ weekLog.name }}</h3>
        </summary>

        <Link
          v-for="workoutLog in weekLog.workoutLogs"
          :key="workoutLog.id"
          :href="
            route('lift.my.programs.workouts.edit', [
              programLog.id,
              workoutLog.id,
            ])
          "
          style="color: blue; text-decoration: none"
        >
          <h4>
            {{ workoutLog.name }}
            <small
              v-if="workoutLog.completedAt"
              style="border: 1px solid green; color: green"
              >Completed</small
            >
          </h4>
        </Link>
      </details>
    </div>
  </div>
</template>
