<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ programLog: Object });
</script>

<template>
  <Layout>
    <template #navigation>
      <Link :href="route('lift.my.programs.index')" class="back-link">
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to programs
      </Link>
    </template>

    <h1 class="page-title">{{ programLog.name }}</h1>

    <div v-for="phaseLog in programLog.phaseLogs" :key="phaseLog.id">
      <h2 class="phase-name">{{ phaseLog.name }}</h2>

      <details
        v-for="weekLog in phaseLog.weekLogs"
        :key="weekLog.id"
        :open="
          weekLog.workoutLogs.some((workoutLog) => !workoutLog.completedAt)
        "
        class="week-details"
      >
        <summary>
          <h3 class="week-name">
            {{ weekLog.name }}
            <small
              v-if="
                weekLog.completedAt ||
                weekLog.workoutLogs.every(
                  (workoutLog) => workoutLog.completedAt
                )
              "
              class="completed-tag"
            >
              <span class="material-symbols-outlined"> check </span>
            </small>
          </h3>
        </summary>

        <div class="workout-logs">
          <Link
            v-for="workoutLog in weekLog.workoutLogs"
            :key="workoutLog.id"
            :href="
              route('lift.my.programs.workouts.edit', [
                programLog.id,
                workoutLog.id,
              ])
            "
            class="workout-log"
          >
            <h4 class="workout-name">
              {{ workoutLog.name }}
            </h4>
            <small v-if="workoutLog.completedAt" class="completed-tag">
              <span class="material-symbols-outlined"> check </span>
            </small>
          </Link>
        </div>
      </details>
    </div>
  </Layout>
</template>

<style scoped>
.week-details {
  border: 2px solid var(--color-neutral-200);
  border-radius: var(--size-base);
  margin-block-end: var(--size-xl);
}

.week-details summary {
  list-style: none;
}

.week-name {
  align-items: center;
  display: flex;
  font-size: var(--size-xl);
  justify-content: space-between;
  margin-block: var(--size-xl);
  padding-inline: var(--size-base) calc(var(--size-3xs) + var(--size-base));
  width: 100%;
}

.phase-name {
  font-size: var(--size-3xl);
  margin-block: var(--size-3xl);
}

.workout-logs {
  padding-inline: var(--size-3xs);
}

.workout-log {
  border: 2px solid var(--color-neutral-200);
  border-radius: var(--size-base);
  display: flex;
  margin-block-end: var(--size-base);
  padding: var(--size-base);
  text-decoration: none;
}

.workout-name {
  align-items: center;
  display: flex;
  justify-content: space-between;
  text-decoration: underline;
  width: 100%;
}

.completed-tag {
  align-items: flex-start;
  border: 2px solid var(--color-lime-500);
  border-radius: var(--size-base);
  color: var(--color-lime-500);
  display: flex;
  font-size: var(--size-base);
  font-weight: 100;
  justify-content: center;
  padding: var(--size-9xs);
  text-decoration: none;
}
</style>
