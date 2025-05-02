<script setup>
import { Link, usePage } from '@inertiajs/vue3';

defineProps({ workoutLog: Object, programLog: Object });

const page = usePage();

const liftStatus = page.props.liftStatus;
</script>

<template>
  <Link
    :href="
      route('lift.my.programs.workouts.edit', [programLog.id, workoutLog.id])
    "
    class="workout-log"
  >
    <h4 class="workout-name">
      {{ workoutLog.name }}
    </h4>
    <small
      v-if="
        workoutLog.status === liftStatus.Completed ||
        workoutLog.status === liftStatus.Skipped
      "
      :class="['status-pill', `status-pill--${workoutLog.status}`]"
    >
      {{ workoutLog.status }}
    </small>
  </Link>
</template>

<style scoped>
.workout-log {
  background-color: var(--color-neutral-50);
  border: 2px solid var(--color-neutral-300);
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
  width: 100%;
}

.status-pill {
  border: 2px solid var(--color-neutral-950);
  border-radius: var(--size-base);
  font-size: var(--size-xs);
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: -0.25px;
  padding: var(--size-4xs) var(--size-2xs);
}

.status-pill--completed {
  border-color: var(--color-lime-500);
  color: var(--color-lime-500);
}

.status-pill--skipped {
  border-color: var(--color-blue-400);
  color: var(--color-blue-400);
}
</style>
