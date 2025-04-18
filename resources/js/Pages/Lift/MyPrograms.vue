<script setup>
import Layout from '../../Layouts/Lift/LiftLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({ programLogs: Object });
</script>

<template>
  <Layout>
    <template #navigation>
      <Link href="/" class="back-link">
        <span class="material-symbols-outlined"> arrow_back_ios </span>
        Back to home
      </Link>
    </template>

    <h1 class="page-title">My Programs</h1>

    <div class="program-logs">
      <Link
        v-for="programLog in programLogs.data"
        :key="programLog.id"
        :href="route('lift.my.programs.show', programLog.id)"
        class="program-log"
      >
        <h2 class="program-name">{{ programLog.name }}</h2>

        <div class="workout-counts">
          <span class="counts"
            >{{ programLog.completedWorkoutCount }}/{{
              programLog.totalWorkoutCount
            }}</span
          >
          days completed
        </div>
      </Link>
    </div>
  </Layout>
</template>

<style scoped>
.program-logs {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: var(--size-base);
}

.program-log {
  aspect-ratio: 1;
  background-color: var(--color-lime-50);
  border: 2px solid var(--color-lime-50);
  border-radius: var(--size-base);
  display: flex;
  flex-direction: column;
  /* align-items: center; */
  justify-content: center;
  text-decoration: none;
  color: inherit;
  padding: var(--size-base);
}

.program-name {
  font-size: var(--size-3xl);
}

.workout-counts span {
  font-family: var(--font-family-mono);
}
</style>
