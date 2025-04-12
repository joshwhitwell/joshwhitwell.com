<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineOptions({ layout: Layout });

defineProps({ programLog: Object });
</script>

<template>
  <div>
    <h1>{{ programLog.name }}</h1>

    <div v-for="phaseLog in programLog.phaseLogs" :key="phaseLog.id">
      <h2>{{ phaseLog.name }}</h2>

      <div v-for="weekLog in phaseLog.weekLogs" :key="weekLog.id">
        <h3>{{ weekLog.name }}</h3>

        <div v-for="workoutLog in weekLog.workoutLogs" :key="workoutLog.id">
          <Link
            :href="
              route('lift.my.programs.workouts.edit', [
                programLog.id,
                workoutLog.id,
              ])
            "
          >
            <h4>{{ workoutLog.name }}</h4>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>
