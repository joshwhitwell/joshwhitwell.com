<script setup>
import MyProgramPhase from '../../Components/Lift/MyProgramPhase.vue';
import MyProgramWeek from '../../Components/Lift/MyProgramWeek.vue';
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

    <div v-if="programLog?.phaseLogs?.length">
      <MyProgramPhase
        v-for="phaseLog in programLog.phaseLogs"
        :key="`phase-log--${phaseLog.id}`"
        :program-log="programLog"
        :phase-log="phaseLog"
      />
    </div>

    <div v-else-if="programLog?.weekLogs?.length">
      <MyProgramWeek
        v-for="weekLog in programLog.weekLogs"
        :key="`week-log--${weekLog.id}`"
        :program-log="programLog"
        :week-log="weekLog"
      />
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
