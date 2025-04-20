<script setup>
import MyProgramWeek from './MyProgramWeek.vue';

defineProps({ phaseLog: Object, programLog: Object });
</script>

<template>
  <div>
    <h2 class="phase-name">{{ phaseLog.name }}</h2>

    <div v-if="phaseLog?.weekLogs?.length">
      <MyProgramWeek
        v-for="weekLog in phaseLog.weekLogs"
        :key="`week-log--${weekLog.id}`"
        :program-log="programLog"
        :week-log="weekLog"
      />
    </div>
  </div>
</template>

<style scoped>
.phase-name {
  font-size: var(--size-3xl);
  margin-block: var(--size-3xl);
}
</style>
