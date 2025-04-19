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
        <div :class="`program-status program-status--${programLog.status}`">
          {{ programLog.statusLabel }}
        </div>

        <h2 class="program-name">{{ programLog.name }}</h2>

        <div class="workout-counts">
          <span class="counts">
            <strong>{{ programLog.completedWorkoutCount }}</strong>
            <span class="slash">/</span>{{ programLog.totalWorkoutCount }}
          </span>
          days completed
        </div>
      </Link>
    </div>
  </Layout>
</template>

<style scoped>
.program-logs {
  display: grid;
  gap: var(--size-base);
  grid-template-columns: repeat(auto-fill, 1fr);
}

.program-log {
  aspect-ratio: 1;
  background: linear-gradient(
    to bottom left,
    var(--color-lime-400) 0%,
    var(--color-neutral-50) 100%
  );
  border-radius: var(--size-base);
  box-sizing: border-box;
  color: inherit;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: var(--size-base);
  text-decoration: none;
}

.program-status {
  background-color: var(--color-neutral-50);
  color: var(--color-neutral-800);
  border-radius: var(--size-base);
  font-weight: 500;
  letter-spacing: -0.02rem;
  padding: var(--size-5xs) var(--size-sm);
  width: fit-content;
}

.program-status--in_progress {
  background-color: var(--color-yellow-200);
  color: var(--color-yellow-800);
}

.program-status--completed {
  background-color: var(--color-lime-400);
  color: var(--color-lime-800);
}

.program-name {
  font-size: var(--size-3xl);
}

.workout-counts {
  color: var(--color-neutral-600);
}

.counts {
  font-family: var(--font-family-mono);
}

.workout-counts strong {
  color: var(--color-neutral-950);
}

.slash {
  margin-inline: var(--size-10xs);
}
</style>
