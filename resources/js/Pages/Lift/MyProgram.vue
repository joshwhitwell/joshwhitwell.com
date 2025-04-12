<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

defineProps({ programLog: Object });
</script>

<template>
  <div>
    <h1>{{ programLog.program.name }}</h1>

    <div v-for="phaseLog in programLog.phase_logs" :key="phaseLog.id">
      <h2>{{ phaseLog.phase.name }}</h2>

      <div v-for="weekLog in phaseLog.week_logs" :key="weekLog.id">
        <h3>{{ weekLog.week.name }}</h3>

        <div v-for="workoutLog in weekLog.workout_logs" :key="workoutLog.id">
          <Link :href="workoutLog.editRoute">
            <h4>{{ workoutLog.workout.name }}</h4>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
